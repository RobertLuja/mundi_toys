<?php

namespace App\Policies;

use App\Http\Enums\PermisoEnum;
use App\Models\Almacen;
use App\Models\Role;
use App\Models\RoleFuncionalidad;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class AlmacenPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //return $user->can("check-permission", PermisoEnum::ViewAny->value);
        // $route = explode("/", Route::current()->uri)[0]; //route almacenes
        // $roleFuncionalidad = RoleFuncionalidad::findForRoleAndRoute($user->rol, $route); //Buscar un role_funcionalidad por role y funcionalidad(route)
        // if(!$roleFuncionalidad) return false;
        // return $this->checkPermission($roleFuncionalidad, PermisoEnum::ViewAny->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Almacen $almacen): bool
    {
        // dd($user); //User autenticado
        // dd($almacen); //Almacen a visitar
        return  false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Almacen $almacen): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Almacen $almacen): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Almacen $almacen): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Almacen $almacen): bool
    {
        //
    }

    private function checkPermission(RoleFuncionalidad $roleFuncionalidad, $permisoValue): bool {
        foreach( $roleFuncionalidad->permisos as $permiso){
            if( $permiso->nombre == $permisoValue && $permiso->pivot->estado == 1 ){
                return true;
            }
        }
        return false;
    }
}
