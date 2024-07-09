<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Almacen;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos =  [];
        $almacenes = Almacen::all();

        foreach( $almacenes as $almacen) {
            foreach($almacen->movimientos as $movimiento) {
                $sqlProducto = 'select stockProducto(?, ?) as "stock";';

                $producto = Producto::find($movimiento->producto->id);
                $stockProducto = DB::select($sqlProducto, [$almacen->nombre, $producto->nombre])[0]->stock;

                $producto->stock = $stockProducto;

                if(!in_array($producto->id, array_column($productos, 'id'))){
                    array_push($productos, $producto);
                }
            }
        }
        return json_decode(json_encode($productos));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
}
