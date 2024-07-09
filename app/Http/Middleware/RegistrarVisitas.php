<?php
// app/Http/Middleware/RegistrarVisitas.php

namespace App\Http\Middleware;

use Closure;
use App\Models\Visita;

class RegistrarVisitas
{
    public function handle($request, Closure $next)
    {
        // Obtener la ruta actual
        $ruta = $request->getPathInfo();

        // Buscar o crear la visita para la ruta actual
        $visita = Visita::firstOrCreate(['ruta' => $ruta]);
        $visita->cantidad++;
        $visita->save();

        return $next($request);
    }
}
