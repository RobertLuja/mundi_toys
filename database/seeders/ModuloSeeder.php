<?php

namespace Database\Seeders;

use App\Models\Funcionalidad;
use App\Models\Modulo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $modulos = [
        [ 
            "nombre" => "Usuarios",
            "descripcion" => "Descripción usuarios",
            "icono" => "bi bi-person-fill",
            "color" => "#1659de",
            "funcionalidades" => [
                [
                    "nombre" => "Usuarios",
                    "descripcion" => "Descripción usuarios",
                    "ruta" => "users"
                ],
                [
                    "nombre" => "Roles",
                    "descripcion" => "Descripción roles",
                    "ruta" => "roles"
                ]
            ]
        ],
        [ 
            "nombre" => "Mi empresa",
            "descripcion" => "Descripción Mi empresa",
            "icono" => "bi bi-building-fill",
            "color" => "#1b91a6",
            "funcionalidades" => [
                [
                    "nombre" => "Dashboard",
                    "descripcion" => "Descripción Dashboard",
                    "ruta" => "dashboard"
                ],
                [
                    "nombre" => "Sucursales",
                    "descripcion" => "Descripción sucursales",
                    "ruta" => "sucursals"
                ],
                [
                    "nombre" => "Almacenes",
                    "descripcion" => "Descripción almacenes",
                    "ruta" => "almacenes"
                ],
                [
                    "nombre" => "Categorías",
                    "descripcion" => "Descripción categorías",
                    "ruta" => "categorias"
                ],
                [
                    "nombre" => "Productos",
                    "descripcion" => "Descripción productos",
                    "ruta" => "productos"
                ],
            ]
        ],
        [ 
            "nombre" => "Transacciones",
            "descripcion" => "Descripción Transacciones",
            "icono" => "bi bi-bank2",
            "color" => "#451c91",
            "funcionalidades" => [
                [
                    "nombre" => "Compras",
                    "descripcion" => "Descripción compras",
                    "ruta" => "compras"
                ],
                [
                    "nombre" => "Bitacora",
                    "descripcion" => "Descripción bitacora",
                    "ruta" => "movimientos"
                ],
                [
                    "nombre" => "Traspaso",
                    "descripcion" => "Descripción traspaso",
                    "ruta" => "traspasos"
                ],
                [
                    "nombre" => "Ventas",
                    "descripcion" => "Descripción ventas",
                    "ruta" => "ventas"
                ],
            ]
        ],
        [ 
            "nombre" => "Configuraciones",
            "descripcion" => "Descripción Configuraciones",
            "icono" => "bi bi-gear-fill",
            "color" => "#717573",
            "funcionalidades" => [
                [
                    "nombre" => "Temas",
                    "descripcion" => "Descripción temas",
                    "ruta" => "temas"
                ],
                [
                    "nombre" => "Modulos",
                    "descripcion" => "Descripción roles",
                    "ruta" => "modulos"
                ],
                [
                    "nombre" => "Funcionalidades",
                    "descripcion" => "Descripción funcionalidades",
                    "ruta" => "funcionalidades"
                ],
                [
                    "nombre" => "Permisos",
                    "descripcion" => "Descripción permisos",
                    "ruta" => "permisos"
                ],
                [
                    "nombre" => "Role-Funcionalidades",
                    "descripcion" => "Descripción Role-Funcionalidades",
                    "ruta" => "roleFuncionalidades"
                ]
            ]
        ],
    ];
    
    public function run(): void
    {
        //Crear modulos
        foreach($this->modulos as $modulo){
            $funcionalidades = $modulo["funcionalidades"];
            unset($modulo["funcionalidades"]);

            $moduloDB = Modulo::create($modulo);
            foreach($funcionalidades as $funcionalidad){
                $funcionalidadDB = Funcionalidad::create($funcionalidad);
                $funcionalidadDB->id_modulo = $moduloDB->id;
                $funcionalidadDB->save();
            }
        }

        //Crear items para los modulos
    }
}
