<?php

namespace Database\Seeders;

use App\Models\Almacen;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //id_sucursal = 1 => 'Sucursal norte'
        //id_sucursal = 2 => 'Sucursal sur'

        $almacen = new Almacen();
        $almacen->nombre = "Almacen oeste santa cruz";
        $almacen->descripcion = "Más vendidos";
        $almacen->estado = 1;
        $almacen->id_sucursal = 1;
        $almacen->fecha_registro = Carbon::now();
        $almacen->save();

        $almacen = new Almacen();
        $almacen->nombre = "Almacen sudeste santa cruz";
        $almacen->descripcion = "Menos vendidos";
        $almacen->estado = 1;
        $almacen->id_sucursal = 2;
        $almacen->fecha_registro = Carbon::now();
        $almacen->save();
    }
}
