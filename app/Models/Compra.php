<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $table = "compra";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $guarded = [];

    public function proveedor() {
        return $this->belongsTo(User::class, "id_proveedor");
    }

    public function usuario() {
        return $this->belongsTo(User::class, "id_usuario");
    }

    public function detalleCompras(){
        return $this->hasMany(DetalleCompra::class, "id_compra");
    }
}
