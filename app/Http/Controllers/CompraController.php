<?php

namespace App\Http\Controllers;

use App\Http\Enums\RoleEnum;
use App\Http\Enums\TipoMovimientoEnum;
use App\Http\Requests\StoreCompraRequest;
use App\Models\Almacen;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize("view-any");
        $compras = Compra::select('*')->cursorPaginate(10);
        return view("compras.index", compact("compras"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize("create");
        //Almacenes activos
        $sqlAlmacen = "
                    SELECT *
                    FROM almacen
                    where estado = ?;";
        $almacenes = DB::select($sqlAlmacen, [1]);

        //Productos activos
        $sqlProducto = "
                    SELECT *
                    FROM producto
                    where estado = ?;";
        $productos = DB::select($sqlProducto, [1]);
        return view("compras.create", compact("almacenes", "productos"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompraRequest $request)
    {
        return $request;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize("view");
        $compra = Compra::find($id);
        return view("compras.show", compact("compra"));
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

    public function guardarCompra(Request $request) {
        Gate::authorize("create");
        $glosa = $request->input("glosa");
        if($glosa == null){
            return response()->json([
                "status" => 400,
                "message" => "Campo glosa requerido"
            ]);
        }

        $ci_proveedor = $request->input("ci_proveedor");
        if($ci_proveedor == null){
            return response()->json([
                "status" => 400,
                "message" => "Campo proveedor requerido"
            ]);
        }

        $sqlProveedor = "select *
                        from usuario
                        where
                        rol = ? and
                        LOWER(TRIM(ci)) = ?";
        $proveedor = DB::select($sqlProveedor, [RoleEnum::Proveedor->value, $ci_proveedor]);

        if(count($proveedor) == 0){
            return response()->json([
                "status" => 400,
                "message" => "Proveedor con ci: $ci_proveedor no existe"
            ]);
        }
        
        try{
            DB::beginTransaction();
            //Guardar compra
            $compra = new Compra();
            $compra->glosa = $glosa;
            $compra->estado = 1;
            $compra->id_proveedor = $proveedor[0]->id;
            $compra->id_usuario = Auth::user()->id;
            $compra->fecha_registro = Carbon::now();
            $compra->save();

            $detallesCompras = $request->input("detalle");
            foreach($detallesCompras as $detalleCompra){
                //Guardar movimiento
                $cantidad = (int)$detalleCompra["cantidad"];

                $movimiento = new Movimiento();
                $movimiento->stock = $cantidad;
                $movimiento->estado = 1;
                $movimiento->tipo = TipoMovimientoEnum::Entrada->value;
                $movimiento->origen = "Compra";
                $movimiento->id_almacen = $detalleCompra["almacen"]["id"];
                $movimiento->id_producto = $detalleCompra["producto"]["id"];
                $movimiento->fecha_registro = Carbon::now();
                $movimiento->save();

                //Guardar detalleCompra
                $detalleCompraSave = new DetalleCompra();
                $detalleCompraSave->cantidad = $cantidad;
                $detalleCompraSave->estado = 1;
                $detalleCompraSave->id_compra = $compra->id;
                $detalleCompraSave->id_movimiento = $movimiento->id;
                $detalleCompraSave->fecha_registro = Carbon::now();
                $detalleCompraSave->save();
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
        $comprasSearch = Compra::whereRaw(
                                    'LOWER(TRIM(glosa)) LIKE ?', ["%$searchTerm%"]
                                )->get();
        return response()->json($comprasSearch);
    }
}
