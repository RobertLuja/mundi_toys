<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = new Role();
        $role->id = 1;
        $role->nombre = "Administrativo";
        $role->descripcion = "Descripción Administrativo";
        $role->save();

        $role = new Role();
        $role->id = 2;
        $role->nombre = "Proveedor";
        $role->descripcion = "Descripción Proveedor";
        $role->save();

        $role = new Role();
        $role->id = 3;
        $role->nombre = "Empleado";
        $role->descripcion = "Descripción Empleado";
        $role->save();

        $role = new Role();
        $role->id = 4;
        $role->nombre = "Cliente";
        $role->descripcion = "Descripción Cliente";
        $role->save();
    }
}
