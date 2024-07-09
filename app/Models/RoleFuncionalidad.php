<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleFuncionalidad extends Model
{   
    
    use HasFactory;
    protected $table = 'role_funcionalidad';
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = ["estado", "fecha_registro", "id_role", "id_funcionalidad", "id_permiso"];


    public function role()
    {
        return $this->belongsTo(Role::class, "id_role");
    }

    public function funcionalidad()
    {
        return $this->belongsTo(Funcionalidad::class, "id_funcionalidad");
    }

    public function permisos() {
        return $this->belongsToMany(Permiso::class, "role_funcionalidad_permiso", "id_role_funcionalidad", "id_permiso")->withPivot("estado");
    }

    public static function findForRoleAndRoute($idRole, $route){
        $role = Role::find($idRole);
        foreach( $role->roleFuncionalidades as $roleFuncionalidad ){
            if(trim(strtolower($roleFuncionalidad->funcionalidad->ruta)) == trim(strtolower($route)))
                return $roleFuncionalidad;
        }
        return null;
    }
}
