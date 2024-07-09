<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sucursal = new Sucursal();
        $sucursal->id = 1;
        $sucursal->nombre = "Sucursal norte";
        $sucursal->direccion = "Av.radial 13 ,5to anillo";
        $sucursal->estado = 1;
        $sucursal->fecha_registro = Carbon::now();
        $sucursal->save();

        $sucursal->id = 2;
        $sucursal = new Sucursal();
        $sucursal->nombre = "Sucursal Sur";
        $sucursal->direccion = "Zona Las Lomas";
        $sucursal->estado = 1;
        $sucursal->fecha_registro = Carbon::now();
        $sucursal->save();
    }
}
