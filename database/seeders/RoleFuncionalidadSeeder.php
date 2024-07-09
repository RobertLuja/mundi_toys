<?php

namespace Database\Seeders;

use App\Models\RoleFuncionalidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleFuncionalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Asignando una funcionalidad al role adminstrativo
        $roleFuncionalidad = new RoleFuncionalidad();
        $roleFuncionalidad->id_role = 1; //Role administrativo
        $roleFuncionalidad->id_funcionalidad = 2; //Funcionalidad de `roles` asignado
        $roleFuncionalidad->save();

        //Asignando permisos al role-funcionalidad
        $roleFuncionalidad->permisos()->attach(1); //Permiso any-view
        $roleFuncionalidad->permisos()->attach(2); //Permiso view
        $roleFuncionalidad->permisos()->attach(3); //Permiso create
        $roleFuncionalidad->permisos()->attach(4); //Permiso update
        $roleFuncionalidad->permisos()->attach(5); //Permiso delete

        //Asignando una funcionalidad al role adminstrativo
        $roleFuncionalidad = new RoleFuncionalidad();
        $roleFuncionalidad->id_role = 1; //Role administrativo
        $roleFuncionalidad->id_funcionalidad = 16; //Funcionalidad de `roleFuncionalidades` asignado
        $roleFuncionalidad->save();

        //Asignando permisos al role-funcionalidad
        $roleFuncionalidad->permisos()->attach(1); //Permiso any-view
        $roleFuncionalidad->permisos()->attach(2); //Permiso view
        $roleFuncionalidad->permisos()->attach(3); //Permiso create
        $roleFuncionalidad->permisos()->attach(4); //Permiso update
        $roleFuncionalidad->permisos()->attach(5); //Permiso delete
    }
}
