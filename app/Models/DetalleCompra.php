<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;
    protected $table = "detalle_compra";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $guarded = [];

    public function compra(){
        return $this->belongsTo(Compra::class, "id_compra");
    }

    public function movimiento() {
        return $this->belongsTo(Movimiento::class, "id_movimiento");
    }

}
