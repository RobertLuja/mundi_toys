<?php

namespace App\Http\Controllers;

use App\Http\Enums\TipoMovimientoEnum;
use App\Models\Almacen;
use App\Models\DetalleTraspaso;
use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\Traspaso;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TraspasoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize("view-any");
        $traspasos = Traspaso::select('*')->cursorPaginate(10);
        return view("traspasos.index", compact("traspasos"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize("create");
        $almacenes = Almacen::all();
        $almacenesOrigen = $almacenes;
        $almacenesDestino = $almacenes;
        return view("traspasos.create", compact("almacenesOrigen", "almacenesDestino"));
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
        //
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
    public function destroy(string $id)
    {
        //
    }

    public function detalleTraspaso(Request $request){
        Gate::authorize("create");
        $almacenOrigenId = $request->input("almacenOrigenId");
        $productoId = $request->input("productoId");
        $cantidad = $request->input("cantidad");

        $producto = Producto::find($productoId);
        $almacen = Almacen::find($almacenOrigenId);

        $sqlProducto = 'select stockProducto(?, ?) as "stock";';
        $stockProducto = DB::select($sqlProducto, [$almacen->nombre, $producto->nombre])[0]->stock;
        
        if((int)$cantidad > (int)$stockProducto){
            return response()->json([
                "status" => 400,
                "message" => "Cantidad excede al stock del producto"
            ]);
        }

        return response()->json([
            "status" => 200,
            "message" => "Detalle agregado"
        ]);
    }

    public function guardarTraspaso(Request $request) {
        Gate::authorize("create");
        $glosa = $request->input("glosa");
        $almacenOrigenId = (int)$request->input("almacenOrigenId");
        $almacenDestinoId = (int)$request->input("almacenDestinoId");
        $detallesTraspasos = $request->input("detalle");

        if($glosa == null){
            return response()->json([
                "status" => 400,
                "message" => "Campo glosa requerido"
            ]);
        }
        

        try{
            DB::beginTransaction();
            //Guardar traspaso
            $traspaso = new Traspaso();
            $traspaso->glosa = $glosa;
            $traspaso->estado = 1;
            $traspaso->id_empleado = Auth::user()->id;
            $traspaso->id_almacen_origen = $almacenOrigenId;
            $traspaso->id_almacen_destino = $almacenDestinoId;
            $traspaso->fecha = Carbon::now();
            $traspaso->fecha_registro = Carbon::now();
            $traspaso->save();

            foreach($detallesTraspasos as $detalleTraspaso){
                //Guardar movimiento
                $cantidad = (int)$detalleTraspaso["cantidad"];

                //Entrada del producto al almacen de destino
                $movimientoDestino = new Movimiento();
                $movimientoDestino->stock = $cantidad;
                $movimientoDestino->estado = 1;
                $movimientoDestino->tipo = TipoMovimientoEnum::Entrada->value;
                $movimientoDestino->origen = "Traspaso";
                $movimientoDestino->id_almacen = $almacenDestinoId;
                $movimientoDestino->id_producto = (int)$detalleTraspaso["producto"]["id"];
                $movimientoDestino->fecha_registro = Carbon::now();
                $movimientoDestino->save();

                //Guardar detalleCompra
                $detalleTraspasoDestino = new DetalleTraspaso();
                $detalleTraspasoDestino->cantidad = $cantidad;
                $detalleTraspasoDestino->estado = 1;
                $detalleTraspasoDestino->id_traspaso = $traspaso->id;
                $detalleTraspasoDestino->id_movimiento = $movimientoDestino->id;
                $detalleTraspasoDestino->fecha_registro = Carbon::now();
                $detalleTraspasoDestino->save();

                //Salida del producto del almacen de origen
                $movimientoOrigen = new Movimiento();
                $movimientoOrigen->stock = $cantidad;
                $movimientoOrigen->estado = 1;
                $movimientoOrigen->tipo = TipoMovimientoEnum::Salida->value;
                $movimientoOrigen->origen = "Traspaso";
                $movimientoOrigen->id_almacen = $almacenOrigenId;
                $movimientoOrigen->id_producto = (int)$detalleTraspaso["producto"]["id"];
                $movimientoOrigen->fecha_registro = Carbon::now();
                $movimientoOrigen->save();

                //Guardar detalleCompra
                $detalleTraspasoOrigen = new DetalleTraspaso();
                $detalleTraspasoOrigen->cantidad = $cantidad;
                $detalleTraspasoOrigen->estado = 1;
                $detalleTraspasoOrigen->id_traspaso = $traspaso->id;
                $detalleTraspasoOrigen->id_movimiento = $movimientoOrigen->id;
                $detalleTraspasoOrigen->fecha_registro = Carbon::now();
                $detalleTraspasoOrigen->save();

            }
            DB::commit();
            return response()->json([
                "status" => 201,
                "message" => "Datos guardados correctamente"
            ]);
        }catch(Exception $exc){
            DB::rollBack();
            return response()->json([
                "status" => 400,
                "message" => "Dato no guardado",
                "detalle" => $exc
            ]);
        }
    }

    public function buscar(Request $request)
    {
        $searchTerm = trim(strtolower($request->input('query')));
        $traspasosSearch = Traspaso::whereRaw('LOWER(TRIM(glosa)) LIKE ?', ["%$searchTerm%"])
                                    ->get();

        foreach($traspasosSearch as $traspaso){
            $traspaso->almacenOrigen;
            $traspaso->almacenDestino;
        }
        return response()->json($traspasosSearch);
    }
}
