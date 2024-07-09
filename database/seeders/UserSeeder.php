<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->id = 1;
        $user->ci = "11122233";
        $user->nombre = "Admin";
        $user->apellido = "Perez";
        $user->genero = "M";
        $user->direccion = "Las Lomas";
        $user->nit = "11122233";
        $user->rol = "Administrativo";
        $user->estado = 1;
        $user->fecha_nacimiento = "1990-01-20";
        $user->email = "admin@gmail.com";
        $user->password = bcrypt("123456");
        $user->fecha_registro = Carbon::now();
        $user->save();

        $user->roles()->attach(1); //Asiganción del id_role administrador
    }
}
