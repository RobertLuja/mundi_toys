<?php

namespace App\Http\Controllers;

use App\Http\Enums\EstadoEnum;
use App\Http\Enums\RoleEnum;
use App\Http\Enums\TipoMovimientoEnum;
use App\Models\Almacen;
use App\Models\DetalleVenta;
use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\Role;
use App\Models\Sucursal;
use App\Models\User;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize("view-any");
        $role = Role::find(Auth::user()->rol);

        if($role->nombre == RoleEnum::Cliente->value){
            $ventas = Venta::whereRaw(
                                'id_cliente = ?', [Auth::user()->id]
                            )->cursorPaginate(5);
        }else{
            $ventas = Venta::select('*')->cursorPaginate(5);
        }
        return view("ventas.index", compact("ventas"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize("create");
        if(Role::find(Auth::user()->rol)->nombre == RoleEnum::Cliente->value){
            $productos = Producto::all();
            $almacenes = Almacen::all();
            $cliente = Auth::user();
            return view("ventas.create", compact("productos", "almacenes", "cliente"));
        }
        return view("ventas.clientes");
    }

    public function createCarrito(Request $request) {
        Gate::authorize("create");
        $productos = Producto::all();
        $almacenes = Almacen::all();
        
        $clienteArray = User::where("ci", '=', (int)$request->ci)->get();
        if(count($clienteArray) == 0)
            return redirect()->route("ventas.create")->with("info", "El cliente no existe, verificar el ci");
        $cliente = $clienteArray[0];

        return view("ventas.create", compact("productos", "almacenes", "cliente"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize("view");
        $venta = Venta::customDetalleVentas($id); //Venta con todos sus detalles
        // return $venta;
        return view("ventas.factura", compact("venta"));
    }

    public function facturaToPdf($id){
        $venta = Venta::customDetalleVentas($id); //Venta con todos sus detalles
        $data = [
            'title' => 'MundyToys',
            'date' => date('m/d/Y'),
            'venta' => $venta
        ];
        $pdf = PDF::loadView("ventas.reports.factura", $data)->setOption(['defaultFont' => 'sans-serif']);
        return $pdf->download('invoice.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) //Se anula la factura
    {   
        Gate::authorize("metodo-pago");
        $venta = $this->cambiarEstadoFactura($id, EstadoEnum::Anulado->value);
        
        /**TODO: Cambiar el estado de la trasacción pagoFacil */
        $pagoFacilController = new PagoFacilController();
        $venta = Venta::customDetalleVentas($id);
        if($venta->pagoFacil != null) {
            $pagoFacilController->actualizarEstadoTransaccion($venta->pagoFacil->id, $venta->pagoFacil->name_image);
        }

        return redirect()->route("ventas.show", compact("venta"))->with("info", "La factura fue anulada correctamente");
    }

    public function pagoEfectivo(string $id) { //Se confirma el pago en efectivo
        Gate::authorize("metodo-pago");
        $venta = $this->cambiarEstadoFactura($id, EstadoEnum::Procesado->value);

        return redirect()->route("ventas.show", compact("venta"))->with("info", "Pago confirmado correctamente!");
    }

    public function cambiarEstadoFactura($id, int $estado){
        $venta = Venta::find($id);
        $venta->estado = $estado;
        $venta->update();

        $detalleVentas = $venta->detalleVentas;

        foreach($detalleVentas as $detalleVenta){
            $detalleVenta->estado = $estado;
            $detalleVenta->update();
            
            $movimiento = $detalleVenta->movimiento;
            $movimiento->estado = $estado;
            if($estado == EstadoEnum::Anulado->value){
                $movimiento->stock = 0;
            }
            $movimiento->update();
        }
        return $venta;
    }

    public function pagarCarrito(Request $request) {
        Gate::authorize("create");
        $detallesCarrito = $request->input("detalleCarrito");
        $idCliente = $request->input("id_cliente");

        if(count($detallesCarrito) == 0){
            return response()->json([
                "status" => 400,
                "message" => "Carrito vacío",
            ]);
        }
        //TODO: Verificar que el usuario-cliente existe, por si se cambia en el front
        $cliente = User::find($idCliente);
        if($cliente == null) {
            return response()->json([
                "status" => 400,
                "message" => "Cliente no encontrado",
            ]);
        }
        if(Role::find($cliente->rol)->nombre != RoleEnum::Cliente->value){
            return response()->json([
                "status" => 400,
                "message" => "El usuario no es un cliente",
            ]);
        }

        //TODO: Verificar que los productos son correspondientes a su almacen

        //TODO: Validar que todos los detalles estan correctos en cuanto a su stock y la cantidad agregado en el detalle

        try{
            DB::beginTransaction();

            //Guardar venta
            $venta = new Venta();
            $venta->glosa = "Venta";
            $venta->estado = EstadoEnum::Pendiente->value;
            $venta->id_cliente = $idCliente;
            $venta->id_usuario = Auth::user()->id;
            $venta->fecha_registro = Carbon::now();
            $venta->save();

            foreach($detallesCarrito as $detalleCarrito) {

                if($detalleCarrito["cantidad"] > $detalleCarrito["product"]["stock"]){
                    throw new Exception("La cantidad: ".$detalleCarrito["cantidad"]." excede al stock del producto ".$detalleCarrito["product"]["nombre"]);
                }
                //Guardar movimiento
                $movimiento = new Movimiento();
                $movimiento->stock = $detalleCarrito["cantidad"];
                $movimiento->estado = 0;
                $movimiento->tipo = TipoMovimientoEnum::Salida->value;
                $movimiento->origen = "Venta";
                $movimiento->id_almacen = $detalleCarrito["id_almacen"];
                $movimiento->id_producto = $detalleCarrito["product"]["id"];
                $movimiento->fecha_registro = Carbon::now();
                $movimiento->save();

                $detalleVenta = new DetalleVenta();
                $detalleVenta->cantidad = $detalleCarrito["cantidad"];
                $detalleVenta->estado = 0;
                $detalleVenta->id_venta = $venta->id;
                $detalleVenta->id_movimiento = $movimiento->id;
                $detalleVenta->fecha_registro = Carbon::now();
                $detalleVenta->save();

            }

            DB::commit();
            return response()->json([
                "status" => 201,
                "message" => "Datos guardados correctamente",
                "data" => $venta
            ]);
        }catch(Exception $exc){
            DB::rollBack();
            return response()->json([
                "status" => 400,
                "message" => "datos no guardado",
                "detalle" => $exc->getMessage()
            ]);
        }
    }

    public function buscar(Request $request)
    {
        $searchTerm = trim(strtolower($request->input('query')));
        $ventasSearch = Venta::whereRaw(
                                    'LOWER(TRIM(glosa)) LIKE ?', ["%$searchTerm%"]
                                )->get();
        return response()->json($ventasSearch);
    }
}
