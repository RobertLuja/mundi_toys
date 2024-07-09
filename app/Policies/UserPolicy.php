<?php

namespace App\Policies;

use App\Http\Enums\PermisoEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

//no used
class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //$role = Role::find($user->rol);
        //dd($role->roleFuncionalidades[0]->permisos);
        //dd($role->roleFuncionalidades[0]->funcionalidad->modulo);
        return $this->checkPermission($user, PermisoEnum::ViewAny->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        dd($user);
        return $this->checkPermission($user, PermisoEnum::View->value);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->checkPermission($user, PermisoEnum::Create->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $this->checkPermission($user, PermisoEnum::Update->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $this->checkPermission($user, PermisoEnum::Delete->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }

    public function checkPermission(User $user, $permisoValue): bool {
        $role = Role::find($user->rol);
        foreach( $role->roleFuncionalidades as $funcionalidad ){
            foreach( $funcionalidad->permisos as $permiso){
                if( $permiso->nombre == $permisoValue && $permiso->pivot->estado == 1 ){
                    return true;
                }
            }
        }
        return false;
    }
}
