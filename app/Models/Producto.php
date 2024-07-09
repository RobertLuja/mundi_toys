<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'producto';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [];

    public function categoria() {
        return $this->belongsTo(Categoria::class, "id_categoria");
    }

    public function movimientos() {
        return $this->hasMany(Movimiento::class, "id_producto");
    }

    public function productosEnAlmacen($idAlmacen, $nombreProducto) {
        $sql = "
            SELECT prod.*
            FROM producto prod, movimiento mov, almacen alm
            WHERE
            prod.id = mov.id_producto AND
            alm.id = mov.id_almacen AND
            alm.id = ? AND
            lower(trim(prod.nombre)) like ?;
        ";
        $productos = DB::select($sql, [$idAlmacen, "%$nombreProducto%"]);
        return $productos;
    }
}
