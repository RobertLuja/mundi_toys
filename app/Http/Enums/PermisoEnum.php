<?php
namespace App\Http\Enums;

enum PermisoEnum: string {

    case ViewAny = "viewAny" ;
    case View = "view";
    case Create = "create";
    case Update = "update";
    case Delete = "delete";
    case MetodoPago = "metodo-pago";
}