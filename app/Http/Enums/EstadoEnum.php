<?php
namespace App\Http\Enums;

enum EstadoEnum: int {

    case Pendiente = 0 ;
    case Procesado = 1;
    case Anulado = 2;
}