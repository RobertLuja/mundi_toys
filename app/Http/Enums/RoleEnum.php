<?php
namespace App\Http\Enums;

enum RoleEnum: string {

    case Administrativo = "Administrativo" ;
    case Proveedor = "Proveedor";
    case Empleado = "Empleado";
    case Cliente = "Cliente";
}