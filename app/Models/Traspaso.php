<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traspaso extends Model
{
    use HasFactory;
    protected $table = 'traspaso';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [];

    public function empleado() {
        return $this->belongsTo(User::class, "id_empleado");
    }

    public function almacenOrigen(){
        return $this->belongsTo(Almacen::class, "id_almacen_origen");
    }

    public function almacenDestino(){
        return $this->belongsTo(Almacen::class, "id_almacen_destino");
    }

    public function detalleTraspasos(){
        return $this->hasMany(DetalleTraspaso::class, "id_traspaso");
    }
}
