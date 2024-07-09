<?php

namespace App\Http\Controllers;

use App\Models\Funcionalidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FuncionalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize("view-any");
        $funcionalidades = Funcionalidad::orderBy("id", "asc")->get();
        return view("funcionalidades.index", compact("funcionalidades"));
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
        Gate::authorize("update");
        $funcionalidad = Funcionalidad::find($id);
        return view("funcionalidades.edit", compact("funcionalidad"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize("update");
        $funcionalidad = Funcionalidad::find($id);
        $funcionalidad->update($request->all());
        return redirect()->route("funcionalidades.index")->with("info", "Funcionalidad actualizado!!!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function buscarFuncionalidad(Request $request){
        $nombre = trim(strtolower($request->input("nombre")));
        $funcionalidad = Funcionalidad::whereRaw("TRIM(LOWER(nombre)) = ?", [ $nombre ])->get();
        if(count($funcionalidad) > 0){
            return response()->json([
                "status" => 200,
                "message" => "Petición exitosa",
                "data" => $funcionalidad[0]
            ]);
        }
        return response()->json([
            "status" => 404,
            "message" => "Funcionalidad no encontrado",
        ]);
    }
}
