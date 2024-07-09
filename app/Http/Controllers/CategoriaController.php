<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Models\Categoria;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize("view-any");
        $categorias = Categoria::all();
        return view("categorias.index", compact("categorias"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize("create");
        return view("categorias.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {
        $categoria = Categoria::create($request->all());
        $categoria->fecha_registro = Carbon::now();
        $categoria->save();

        return redirect()->route("categorias.index")->with("info", "Nueva categoría agregado");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize("view");
        $categoria = Categoria::find($id);
        $title = $categoria->nombre;
        return view("categorias.show", compact("categoria", "title"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize("update");
        $categoria = Categoria::find($id);
        return view("categorias.edit", compact("categoria"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoriaRequest $request, string $id)
    {
        Gate::authorize("update");
        $categoria = Categoria::find($id);
        $categoria->update($request->all());

        return redirect()->route("categorias.index")->with("info", "
        Categoria: $categoria->nombre actualizado!!!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize("delete");
        $categoria = Categoria::find($id);
        $nombre = $categoria->nombre;
        
        $categoria->delete();
        return redirect()->route("categorias.index")->with("info", "
        Categoria: $nombre eliminado!!!");
    }

    public function buscar(Request $request)
    {
        $searchTerm = trim(strtolower($request->input('query')));
        $categoriasSearch = Categoria::whereRaw(
                                        'LOWER(TRIM(nombre)) LIKE ?', ["%$searchTerm%"]
                                    )->get();
        return response()->json($categoriasSearch);
    }

    public function buscarById(Request $request)
    {
        $categoriaId = $request->input('query');
        $categoriaSearch = Categoria::find($categoriaId);
        return response()->json($categoriaSearch);
    }

    public function cantidadProductos(){
        //Consulta que devuelve la cantidad de productos que corresponde a su categoría correspondiente
        $categorias = Categoria::all();
        foreach($categorias as $categoria){
            $categoria->cantidad = count($categoria->productos);
        }

        return response()->json([
            "status" => 200,
            "data" => $categorias
        ]);
    }
}
