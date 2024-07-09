<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;
    protected $table = 'almacen';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [];

    public function sucursal() {
        return $this->belongsTo(Sucursal::class, "id_sucursal");
    }

    public function movimientos() {
        return $this->hasMany(Movimiento::class, "id_almacen");
    }

    public function traspasosOrigen() {
        return $this->hasMany(Traspaso::class, "id_almacen_origen");
    }

    public function traspasosDestino() {
        return $this->hasMany(Traspaso::class, "id_almacen_destino");
    }
}
