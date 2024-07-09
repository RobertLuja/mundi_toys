<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use OrigenMovimiento;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize("view-any");
        $movimientos = Movimiento::select("*")->cursorPaginate(10);
        return view("movimientos.index", compact("movimientos"));
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
        // $movimiento = Movimiento::find($id);
        
        // if($movimiento == OrigenMovimiento::Compra)
        
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

    public function buscar(Request $request)
    {
        $searchTerm = trim(strtolower($request->input('query')));
        $movimientosSearch = Movimiento::whereRaw('LOWER(TRIM(tipo)) LIKE ?', ["%$searchTerm%"])
                        ->orWhereRaw('LOWER(TRIM(origen)) LIKE ?', ["%$searchTerm%"])
                        ->get();

        foreach($movimientosSearch as $movimiento){
            $movimiento->almacen;
            $movimiento->producto;
        }
        return response()->json($movimientosSearch);
    }
}
