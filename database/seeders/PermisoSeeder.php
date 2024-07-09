<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private $permisos = [
        [
            "nombre" => "viewAny",
            "descripcion" => "Ver todos los datos"
        ],
        [
            "nombre" => "view",
            "descripcion" => "Ver un dato especifico"
        ],
        [
            "nombre" => "create",
            "descripcion" => "Crear un nuevo registro"
        ],
        [
            "nombre" => "update",
            "descripcion" => "Actualizar un registro"
        ],
        [
            "nombre" => "delete",
            "descripcion" => "Eliminar un registro"
        ],
        [
            "nombre" => "metodo-pago",
            "descripcion" => "Acceso a los métodos de pagos"
        ]
    ];

    public function run(): void
    {
        foreach($this->permisos as $permiso){
            Permiso::create($permiso);
        }
    }
}
