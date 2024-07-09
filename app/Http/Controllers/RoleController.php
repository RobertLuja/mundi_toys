<?php

namespace App\Http\Controllers;

use App\Models\Funcionalidad;
use App\Models\Permiso;
use App\Models\Role;
use App\Models\RoleFuncionalidad;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize("view-any");
        $roles = Role::all();
        return view("roles.index", compact("roles"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize("create");
        return view("roles.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize("create");
        $request->validate([
            "nombre" => "required|min:3|max:100"   
        ]);
        Role::create($request->all());
        return redirect()->route("roles.index")->with("info", "Rol creado!!!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Gate::authorize("view");
        $role = Role::find($id);
        $misFuncionalidades = $role->roleFuncionalidades;
        $nuevasFuncionalidades = $this->funcionalidadesNoAgregadas($misFuncionalidades);
        return view("roles.show", compact("role", "nuevasFuncionalidades"));
    }

    private function funcionalidadesNoAgregadas($misFuncionalidades) {
        $funcionalidades = Funcionalidad::all();
        $nuevasFuncionalidades = [];
        foreach( $funcionalidades as $funcionalidad ) {
            if( !in_array($funcionalidad->id, array_column(json_decode($misFuncionalidades), "id_funcionalidad")) ){
                array_push($nuevasFuncionalidades, $funcionalidad);
            }
        }
        return $nuevasFuncionalidades;
    }

    public function guardarNuevasFuncionalidades(Request $request) {
        Gate::authorize("create");
        $id_role = $request->input("id_role");
        $role = Role::find($id_role);
        if(!$role){
            return redirect()->route("roles.index")->with("info", "Error en visualizar el rol");
        }
        
        $id_funcionalidades = $request->input("id_funcionalidades");
        if( !$id_funcionalidades ){
            return redirect()->route("roles.show", $role)->with("error", "Seleccione al menos una funcionalidad");
        }

        /**TODO: Verificar que todos las id_funcionalidades existan */
        foreach( $id_funcionalidades as $id_funcionalidad){
            RoleFuncionalidad::create([
                "id_role" => $id_role,
                "id_funcionalidad" => $id_funcionalidad
            ]);
        }

        return redirect()->route("roles.show", $role)->with("success", "Nuevas funcionalidades agregadas");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize("update");
        $role = Role::find($id);
        return view("roles.edit", compact("role"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize("update");
        $request->validate([
            "nombre" => "required|min:3|max:100"   
        ]);
        $id_funcionalidades = $request->input("id_funcionalidades");

        if(!$id_funcionalidades){
            $id_funcionalidades = [];
        }
        
        $role = Role::find($id);
        $role->update($request->all());
        $this->actualizarFuncionalidades($role, $id_funcionalidades);
        return redirect()->route("roles.index")->with("info", "Rol $role->nombre actualizado!!!");
    }

    private function actualizarFuncionalidades(Role $role, $inputFuncionalidades) {
        /**TODO: Realizar verificación de la existencia de los inputFuncionalidades */
        foreach( $role->roleFuncionalidades as $roleFuncionalidad ){
            if(in_array($roleFuncionalidad->id, $inputFuncionalidades)){ //Actualizar estado a true
                $estado = 1;
            }else { //Actualizar estado a false
                $estado = 0;
            }
            $roleFuncionalidad->update(["estado" => $estado]);
        }
        return true;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize("delete");
        $role = Role::find($id);
        $role->delete();
        return redirect()->route("roles.index")->with("info", "Rol eliminado!!!");
    }
}
