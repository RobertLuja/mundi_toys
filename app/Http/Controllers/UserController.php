<?php

namespace App\Http\Controllers;

use App\Http\Enums\RoleEnum;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            Gate::authorize("view-any");
        }catch (AuthorizationException $e){
            return redirect()->route("dashboard.index");
        }

        $users = User::select("*")->cursorPaginate(10);
        return view("usuarios.index", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize("create");
        $roles = Role::all();
        return view("usuarios.create", compact("roles"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {   
        $role = Role::find($request->rol);
        if($role){
            //--------Registramos al usuario
            $request->merge(['password' => bcrypt($request->password)]);
            $user = User::create($request->all());
            
            $user->fecha_registro = Carbon::now();
            $user->save();
            
            $user->roles()->attach($role->id); //Guardamos el rol correspondiente
            return redirect()->route("users.index")->with("info", "Usuario creado!!!");
        }
        return "No existe el rol";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize("view");
        $user = User::find($id);
        $title = $user->nombre . " " . $user->apellido;
        return view("usuarios.show", compact("user", "title"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize("update");
        $user = User::find($id);
        $roles = Role::all();
        return view("usuarios.edit", compact("user", "roles"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        Gate::authorize("update");
        $user = User::find($id);
        $user->update($request->all());

        return redirect()->route("users.index")->with("info", "Usuario con ci: $user->ci actualizado!!!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize("delete");
        $user = User::find($id);
        $name = "$user->nombre $user->apellido";
        $user->delete();
        return redirect()->route("users.index")->with("info", "$name eliminado!!!");
    }

    public function buscar(Request $request)
    {
        $searchTerm = trim(strtolower($request->input('query')));
        $usuariosSearch = User::whereRaw('LOWER(TRIM(nombre)) LIKE ?', ["%$searchTerm%"])
                        ->orWhereRaw('LOWER(TRIM(apellido)) LIKE ?', ["%$searchTerm%"])
                        ->get();
        return response()->json($usuariosSearch);
    }

    public function buscarForCI(Request $request)
    {
        $ci = trim(strtolower($request->input('query')));
        $users = User::whereRaw('LOWER(TRIM(ci)) LIKE ?', ["%$ci%"])->get();
        return response()->json($users);
    }

    public function buscarProveedores(Request $request){
        $ci = trim(strtolower($request->input('query')));
        $proveedores = User::whereRaw('rol = ? and LOWER(TRIM(ci)) LIKE ?', 
                                    [RoleEnum::Proveedor->value, "%$ci%"])->get();
        return response()->json($proveedores);
    }

    public function buscarEmpleados(Request $request){
        $ci = trim(strtolower($request->input('query')));
        $empleados = User::whereRaw('rol = ? and LOWER(TRIM(ci)) LIKE ?', 
                                    [RoleEnum::Empleado->value, "%$ci%"])->get();
        return response()->json($empleados);
    }

    public function buscarClientes(Request $request){ //Solucionar este problema
        $ci = trim(strtolower($request->input('query')));
        $clientes = User::whereRaw('rol = ? and LOWER(TRIM(ci)) LIKE ?', 
                                    [RoleEnum::Cliente->value, "%$ci%"])->get();
        return response()->json($clientes);
    }
}
