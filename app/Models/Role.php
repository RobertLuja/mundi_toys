<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = "role";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        "nombre", "descripcion"
    ];

    public function usuarios() {
        return $this->belongsToMany(User::class, "role_usuario", "id_role", "id_usuario");
    }

    // public function funcionalidades() {
    //     return $this->belongsToMany(Funcionalidad::class, "role_funcionalidad", "id_role", "id_funcionalidad");
    // }

    public function roleFuncionalidades() {
        return $this->hasMany(RoleFuncionalidad::class, "id_role");
    }
}
