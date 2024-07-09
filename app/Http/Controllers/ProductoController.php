<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize("view-any");
        $productos = Producto::all();
        return view("productos.index", compact("productos"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize("create");
        $categorias = Categoria::all();
        return view("productos.create", compact("categorias"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductoRequest $request)
    {   
        Gate::authorize("create");
        $producto = Producto::create($request->all());
        $producto->fecha_registro = Carbon::now();
        $producto->save();

        return redirect()->route("productos.index")->with("info", "Nuevo producto agregado");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize("view");
        $producto = Producto::find($id);
        $title = $producto->nombre;
        return view("productos.show", compact("producto", "title"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize("update");
        $producto = Producto::find($id);
        $categorias = Categoria::all();
        return view("productos.edit", compact("producto", "categorias"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductoRequest $request, string $id)
    {
        Gate::authorize("update");
        $producto = Producto::find($id);
        $producto->update($request->all());

        return redirect()->route("productos.index")->with("info", "
        Producto: $producto->nombre actualizado!!!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize("delete");
        $producto = Producto::find($id);
        $nombre = $producto->nombre;
        
        $producto->delete();
        return redirect()->route("productos.index")->with("info", "
        Producto: $nombre eliminado!!!");
    }

    public function buscar(Request $request)
    {
        $searchTerm = trim(strtolower($request->input('query')));
        $productosSearch = Producto::whereRaw(
                                    'LOWER(TRIM(nombre)) LIKE ?', ["%$searchTerm%"]
                                )->get();
        return response()->json($productosSearch);
    }

    public function buscarById(Request $request)
    {
        $productoId = $request->input('query')["id_producto"];
        $almacenId = $request->input('query')["id_almacen"];
        $producto = Producto::find($productoId);
        $almacen = Almacen::find($almacenId);

        $sqlProducto = 'select stockProducto(?, ?) as "stock";';
        $stockProducto = DB::select($sqlProducto, [$almacen->nombre, $producto->nombre])[0]->stock;
        $producto->stock = $stockProducto;
        
        return response()->json($producto);
    }

    public function buscarByName(Request $request)
    {
        $queryProduct = $request->input('query');
        $almacenId = $request->input('id_almacen');

        $almacen = Almacen::find($almacenId);

        $producto = new Producto();
        $productosEnAlmacen = $producto->productosEnAlmacen($almacen->id, $queryProduct);

        $productosWithStock = [];
        foreach($productosEnAlmacen as $productoEnAlmacen) {

            $sqlProducto = 'select stockProducto(?, ?) as "stock";';
            $stockProducto = DB::select($sqlProducto, [$almacen->nombre, $productoEnAlmacen->nombre])[0]->stock;
            
            $productoEnAlmacen->stock = $stockProducto;

            if(!in_array($productoEnAlmacen->id, array_column($productosWithStock, 'id'))){
                array_push($productosWithStock, $productoEnAlmacen);
            }
        }
        return response()->json($productosWithStock);
    }
}
