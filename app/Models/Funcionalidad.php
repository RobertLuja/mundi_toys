<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionalidad extends Model
{
    use HasFactory;
    protected $fillable = ["nombre", "descripcion", "ruta", "estado"];
    protected $table = "funcionalidad";
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function modulo() {
        return $this->belongsTo(Modulo::class, "id_modulo");
    }

    // public function roles() {
    //     return $this->belongsToMany(Role::class, "role_funcionalidad", "id_funcionalidad", "id_role");
    // }

    public function roleFuncionalidades() {
        return $this->hasMany(RoleFuncionalidad::class, "id_funcionalidad");
    }
}
