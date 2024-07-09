<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;
    protected $table = "detalle_venta";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $guarded = [];

    public function venta() {
        return $this->belongsTo(Venta::class, "id_venta");
    }

    public function movimiento() {
        return $this->belongsTo(Movimiento::class, "id_movimiento");
    }
}
