<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\RoleFuncionalidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleFuncionalidadController extends Controller
{

    public function index() {
        Gate::authorize("view-any");
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {   
        Gate::authorize("view");
        $roleFuncionalidad = RoleFuncionalidad::find($id);
        $nuevosPermisos = $this->permisosNoAgregados($roleFuncionalidad->permisos);
        return view("roles.role_funcionalidad.show", compact("roleFuncionalidad", "nuevosPermisos"));
    }

    private function permisosNoAgregados($misPermisos) {
        $permisos = Permiso::all();
        $nuevosPermisos = [];
        foreach( $permisos as $permiso ) {
            
            $existe_permiso = 
                        $misPermisos->contains(
                                function ($miPermiso) use ($permiso) {
                                    return $miPermiso->pivot->id_permiso == $permiso->id;
                                });
            if(!$existe_permiso){
                array_push($nuevosPermisos, $permiso);
            }
        }
        return $nuevosPermisos;
    }

    public function guardarNuevosPermisos(Request $request) {
        Gate::authorize("create");
        $id_role_funcionalidad = $request->input("id_role_funcionalidad");
        $roleFuncionalidad = RoleFuncionalidad::find($id_role_funcionalidad);
        if(!$roleFuncionalidad){
            return redirect()->route("roles.index")->with("info", "Error con roleFuncionalidad-Permiso");
        }
        
        $id_permisos = $request->input("id_permisos");
        if( !$id_permisos ){
            return redirect()->route("roleFuncionalidades.show", $id_role_funcionalidad)->with("error", "Seleccione al menos un permiso");
        }

        /**TODO: Verificar que todos las id_permisos existan */
        foreach( $id_permisos as $id_permiso){
            $roleFuncionalidad->permisos()->attach($id_permiso);
        }

        return redirect()->route("roleFuncionalidades.show", $id_role_funcionalidad)->with("success", "Nuevos permisos agregados");
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize("update");
        $roleFuncionalidad = RoleFuncionalidad::find($id);
        return view("roles.role_funcionalidad.edit", compact("roleFuncionalidad"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize("update");
        $id_permisos = $request->input("id_permisos");

        if(!$id_permisos){
            $id_permisos = [];
        }
        
        $roleFuncionalidad = RoleFuncionalidad::find($id);

        $this->actualizarPermisos($roleFuncionalidad, $id_permisos);
        return redirect()->route("roles.show", $roleFuncionalidad->role->id)->with("success", "Permisos actualizados correctamente!!!");
    }

    private function actualizarPermisos(RoleFuncionalidad $roleFuncionalidad, $inputPermisos) {
        /**TODO: Realizar verificación de la existencia de los inputPermisos */
        foreach( $roleFuncionalidad->permisos as $permiso ){
            if(in_array($permiso->id, $inputPermisos)){ //Actualizar estado a true
                $estado = 1;
            }else { //Actualizar estado a false
                $estado = 0;
            }
            $permiso->pivot->update(["estado" => $estado]);
        }
        return true;
    }

}
