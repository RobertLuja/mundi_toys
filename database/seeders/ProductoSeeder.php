<?php

namespace Database\Seeders;

use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //id_categoria = 1 => 'Categoria computadoras'
        //id_categoria = 2 => 'Categoria celulares'
        //id_categoria = 3 => 'Categoria televisores'
        //id_categoria = 4 => 'Categoria relojes'
        
        $producto = new Producto();
        $producto->nombre = "Computadora HP G1 Core i3";
        $producto->precio = 2000.0;
        $producto->estado = 1;
        $producto->id_categoria = 1;
        $producto->fecha_registro = Carbon::now();
        $producto->save();

        $producto = new Producto();
        $producto->nombre = "Computadora HP G2 Core i3";
        $producto->precio = 2500.0;
        $producto->estado = 1;
        $producto->id_categoria = 1;
        $producto->fecha_registro = Carbon::now();
        $producto->save();

        $producto = new Producto();
        $producto->nombre = "Xiaomi Poco X5 Pro";
        $producto->precio = 2000.0;
        $producto->estado = 1;
        $producto->id_categoria = 2;
        $producto->fecha_registro = Carbon::now();
        $producto->save();

        $producto = new Producto();
        $producto->nombre = "Xiaomi note 13 Pro";
        $producto->precio = 2220.0;
        $producto->estado = 1;
        $producto->id_categoria = 2;
        $producto->fecha_registro = Carbon::now();
        $producto->save();

        $producto = new Producto();
        $producto->nombre = "TV Samsung Galaxy G1";
        $producto->precio = 3000.0;
        $producto->estado = 1;
        $producto->id_categoria = 3;
        $producto->fecha_registro = Carbon::now();
        $producto->save();

        $producto = new Producto();
        $producto->nombre = "TV Samsung Galaxy G2";
        $producto->precio = 3300.0;
        $producto->estado = 1;
        $producto->id_categoria = 3;
        $producto->fecha_registro = Carbon::now();
        $producto->save();

        $producto = new Producto();
        $producto->nombre = "Smartwatch Moto G1";
        $producto->precio = 1200.0;
        $producto->estado = 1;
        $producto->id_categoria = 4;
        $producto->fecha_registro = Carbon::now();
        $producto->save();

        $producto = new Producto();
        $producto->nombre = "Smartwatch Moto G2";
        $producto->precio = 1400.0;
        $producto->estado = 1;
        $producto->id_categoria = 4;
        $producto->fecha_registro = Carbon::now();
        $producto->save();

        $producto = new Producto();
        $producto->nombre = "Smartwatch Moto G3";
        $producto->precio = 1250.0;
        $producto->estado = 1;
        $producto->id_categoria = 4;
        $producto->fecha_registro = Carbon::now();
        $producto->save();
    }
}
