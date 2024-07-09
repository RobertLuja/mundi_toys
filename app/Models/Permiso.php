<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;
    protected $table = "permiso";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        "nombre", "descripcion"
    ];

    public function roleFuncionalidades() {
        return $this->belongsToMany(RoleFuncionalidad::class, "role_funcionalidad_permiso", "id_permiso", "id_role_funcionalidad")->withPivot("estado");
    }
}
