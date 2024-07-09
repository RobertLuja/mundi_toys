<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleTraspaso extends Model
{
    use HasFactory;
    protected $table = "detalle_traspaso";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $guarded = [];

    public function traspaso(){
        return $this->belongsTo(Traspaso::class, "id_traspaso");
    }

    public function movimiento() {
        return $this->belongsTo(Movimiento::class, "id_movimiento");
    }
}
