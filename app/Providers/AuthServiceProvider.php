<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Http\Enums\PermisoEnum;
use App\Models\Almacen;
use App\Models\RoleFuncionalidad;
use App\Models\User;
use App\Policies\AlmacenPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // User::class => UserPolicy::class,
        // Almacen::class => AlmacenPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //Puerta para verificar si el usuario autenticado tiene permiso a su role-funcionalidad correspondiente
        Gate::define('view-any', function (User $user) {
            return $this->checkPermission($user, PermisoEnum::ViewAny->value);
        });

        Gate::define('view', function (User $user) {
            return $this->checkPermission($user, PermisoEnum::View->value);
        });

        Gate::define('create', function (User $user) {
            return $this->checkPermission($user, PermisoEnum::Create->value);
        });

        Gate::define('update', function (User $user) {
            return $this->checkPermission($user, PermisoEnum::Update->value);
        });

        Gate::define('delete', function (User $user) {
            return $this->checkPermission($user, PermisoEnum::Delete->value);
        });

        Gate::define('metodo-pago', function (User $user) {
            return $this->checkPermission($user, PermisoEnum::MetodoPago->value);
        });
    }

    public function checkPermission(User $user, $permisoValue) {
        $route = explode("/", Route::current()->uri)[0]; // current route
        // dd($route);
        $roleFuncionalidad = RoleFuncionalidad::findForRoleAndRoute($user->rol, $route); //Buscar un role_funcionalidad por role y funcionalidad(route)
        if(!$roleFuncionalidad) return false;

        foreach( $roleFuncionalidad->permisos as $permiso){
            if( $permiso->nombre == $permisoValue && $permiso->pivot->estado == 1 ){
                return true;
            }
        }
        return false;
    }
}
