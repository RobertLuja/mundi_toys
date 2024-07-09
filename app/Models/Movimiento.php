<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;
    protected $table = "movimiento";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $guarded = [];

    
    public function producto() {
        return $this->belongsTo(Producto::class, "id_producto");
    }
    
    public function almacen() {
        return $this->belongsTo(Almacen::class, "id_almacen");
    }
    
    public function detalleCompras(){
        return $this->hasMany(DetalleCompra::class, "id_movimiento");
    }

    public function detalleTraspasos(){
        return $this->hasMany(DetalleTraspaso::class, "id_movimiento");
    }

    public function detalleVentas(){
        return $this->hasMany(DetalleVenta::class, "id_movimiento");
    }
}
