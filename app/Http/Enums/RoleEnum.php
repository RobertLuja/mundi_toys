<?php
namespace App\Http\Enums;

enum RoleEnum: int {

    // case Administrativo = "Administrativo" ;
    // case Proveedor = "Proveedor";
    // case Empleado = "Empleado";
    // case Cliente = "Cliente";

    case Administrativo = 1 ;
    case Proveedor      = 2;
    case Empleado       = 3;
    case Cliente        = 4;
}