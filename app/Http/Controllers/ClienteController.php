<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::select("*")->cursorPaginate(10);
        return view("clientes.index", compact("clientes"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("clientes.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request)
    {
        $cliente = Cliente::create($request->all());
        $cliente->fecha_registro = Carbon::now();
        $cliente->save();

        return redirect()->route("clientes.index")->with("info", "Nuevo cliente agregado");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cliente = Cliente::find($id);
        $title = $cliente->nombre . " " . $cliente->apellido;
        return view("clientes.show", compact("cliente", "title"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cliente = Cliente::find($id);
        return view("clientes.edit", compact("cliente"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreClienteRequest $request, string $id)
    {
        $cliente = Cliente::find($id);
        $cliente->update($request->all());

        return redirect()->route("clientes.index")->with("info", "
        Cliente: $cliente->apellido actualizado!!!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cliente = Cliente::find($id);
        $nombre = $cliente->apellido;
        
        $cliente->delete();
        return redirect()->route("clientes.index")->with("info", "
        Cliente: $nombre eliminado!!!");
    }

    public function buscar(Request $request)
    {
        $searchTerm = trim(strtolower($request->input('query')));
        $clientesSearch = Cliente::whereRaw('LOWER(TRIM(nombre)) LIKE ?', ["%$searchTerm%"])
                        ->orWhereRaw('LOWER(TRIM(apellido)) LIKE ?', ["%$searchTerm%"])
                        ->get();
        return response()->json($clientesSearch);
    }
}
