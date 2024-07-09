<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSucursalRequest;
use App\Models\Sucursal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize("view-any");
        $sucursals = Sucursal::all();
        return view("sucursals.index", compact("sucursals"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize("create");
        return view("sucursals.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSucursalRequest $request)
    {
        Gate::authorize("create");
        $sucursal = Sucursal::create($request->all());
        $sucursal->fecha_registro = Carbon::now();
        $sucursal->save();

        return redirect()->route("sucursals.index")->with("info", "Nuevo sucursal agregado");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize("view");
        $sucursal = Sucursal::find($id);
        $title = $sucursal->nombre;
        return view("sucursals.show", compact("sucursal", "title"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize("update");
        $sucursal = Sucursal::find($id);
        return view("sucursals.edit", compact("sucursal"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSucursalRequest $request, string $id)
    {
        Gate::authorize("update");
        $sucursal = Sucursal::find($id);
        $sucursal->update($request->all());

        return redirect()->route("sucursals.index")->with("info", "
        Sucursal: $sucursal->nombre actualizado!!!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize("delete");
        $sucursal = Sucursal::find($id);
        $nombre = $sucursal->nombre;
        
        $sucursal->delete();
        return redirect()->route("sucursals.index")->with("info", "
        Sucursal: $nombre eliminado!!!");
    }

    public function buscar(Request $request)
    {
        $searchTerm = trim(strtolower($request->input('query')));
        $sucursalsSearch = Sucursal::whereRaw('LOWER(TRIM(nombre)) LIKE ?', ["%$searchTerm%"])
                        ->orWhereRaw('LOWER(TRIM(direccion)) LIKE ?', ["%$searchTerm%"])
                        ->get();
        return response()->json($sucursalsSearch);
    }

    public function buscarById(Request $request)
    {
        $sucursalId = $request->input('query');
        $sucursalSearch = Sucursal::find($sucursalId);
        return response()->json($sucursalSearch);
    }
}
