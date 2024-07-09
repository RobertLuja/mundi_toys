<?php

namespace App\Http\Controllers;

use App\Http\Enums\PermisoEnum;
use App\Models\Almacen;
use App\Models\Producto;
use App\Models\Sucursal;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            // $this->authorize("viewAny", Almacen::class);
            Gate::authorize("view-any");
        }catch (AuthorizationException $e){
            return redirect()->route("home");
        }
        $almacenes = Almacen::all();
        return view("almacenes.index", compact("almacenes"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize("create", Almacen::class);
        Gate::authorize("create");
        $sucursals = Sucursal::all();
        return view("almacenes.create", compact("sucursals"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $request->validate([
            "nombre" => "required|min:3|max:100",
            'estado' => 'required|in:1,0',   
        ]);

        $almacen = Almacen::create($request->all());
        $almacen->fecha_registro = Carbon::now();
        $almacen->save();

        return redirect()->route("almacenes.index")->with("info", "Nuevo almacen agregado");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize("view");
        $almacen = Almacen::find($id);
        $title = $almacen->nombre;
        $productos = $this->getProductos($almacen);
        return view("almacenes.show", compact("almacen", "title", "productos"));
    }

    public function getProductos(Almacen $almacene){
        $nombreAlmacen = $almacene->nombre;
        $movimientos = $almacene->movimientos;

        $productos = [];
        foreach($movimientos as $movimiento){
            $sqlProducto = 'select stockProducto(?, ?) as "stock";';

            $producto = Producto::find($movimiento->producto->id);
            $stockProducto = DB::select($sqlProducto, [$nombreAlmacen, $producto->nombre])[0]->stock;

            $producto->stock = $stockProducto;

            if(!in_array($producto->id, array_column($productos, 'id'))){
                array_push($productos, $producto);
            }
        }
        $productos = json_decode(json_encode($productos));
        return $productos;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize("update");
        $almacen = Almacen::find($id);
        $sucursals = Sucursal::all();
        return view("almacenes.edit", compact("almacen", "sucursals"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize("update");
        $request->validate([
            "nombre" => "required|min:3|max:100",
            'estado' => 'required|in:1,0',   
        ]);
        $almacen = Almacen::find($id);
        $almacen->update($request->all());

        return redirect()->route("almacenes.index")->with("info", "
        Almacen: $almacen->nombre actualizado!!!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize("delete");
        $almacen = Almacen::find($id);
        $nombre = $almacen->nombre;
        
        $almacen->delete();
        return redirect()->route("almacenes.index")->with("info", "
        Almacen: $nombre eliminado!!!");
    }

    public function buscar(Request $request)
    {
        $searchTerm = trim(strtolower($request->input('query')));
        $almacenesSearch = Almacen::whereRaw(
                                    'LOWER(TRIM(nombre)) LIKE ?', ["%$searchTerm%"]
                                )->get();
        return response()->json($almacenesSearch);
    }

    public function buscarById(Request $request)
    {
        $almacenId = $request->input('query');
        $almacenSearch = Almacen::find($almacenId);
        $almacenSearch->sucursal;
        return response()->json($almacenSearch);
    }

    public function buscarAlmacenProductos(Request $request)
    {
        $almacenId = $request->input('query');
        $almacenSearch = Almacen::find($almacenId);
        $productos = $this->getProductos($almacenSearch);
        return response()->json([
                            "almacen" => $almacenSearch,
                            "productos" => $productos
                        ]);
    }
}
