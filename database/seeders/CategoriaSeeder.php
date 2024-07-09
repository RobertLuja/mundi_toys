<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoria = new Categoria();
        $categoria->id = 1;
        $categoria->nombre = "Computadoras";
        $categoria->estado = 1;
        $categoria->fecha_registro = Carbon::now();
        $categoria->save();

        $categoria = new Categoria();
        $categoria->id = 2;
        $categoria->nombre = "Celulares";
        $categoria->estado = 1;
        $categoria->fecha_registro = Carbon::now();
        $categoria->save();

        $categoria = new Categoria();
        $categoria->id = 3;
        $categoria->nombre = "Televisores";
        $categoria->estado = 1;
        $categoria->fecha_registro = Carbon::now();
        $categoria->save();

        $categoria = new Categoria();
        $categoria->id = 4;
        $categoria->nombre = "Relojes";
        $categoria->estado = 1;
        $categoria->fecha_registro = Carbon::now();
        $categoria->save();
    }
}
