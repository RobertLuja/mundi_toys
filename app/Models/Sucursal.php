<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;
    protected $table = 'sucursal';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [];

    public function almacenes() {
        return $this->hasMany(Almacen::class, "id_sucursal");
    }
}
