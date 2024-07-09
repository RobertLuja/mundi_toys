<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view("login.index");
    }

    public function ingresar(Request $request) {
        $id_role = $request->id_role;

        $credentials = $request->validate([
            "email" => "required | email",
            "password" => "required"
        ]);

        $remember = $request->filled("remember");

        /** Validar si el usuario tiene este rol */
        $roleFind = Role::find($id_role);
        if(!$roleFind){
            return redirect()->route("login")->with("info", "El rol no existe");
        }

        if( Auth::validate($credentials) ){
            $user = Auth::getLastAttempted();

            //Verificar si el rol seleccionado es el mismo que ya tiene guardado en la base de datos, para no buscar otros roles.
            if( $user->rol == $roleFind->id ){
                if( Auth::attempt($credentials, $remember) ){
                    $request->session()->regenerate();
                    return redirect()->route("dashboard.index");
                }
            }

            //Buscar si tiene asignado el rol seleccionado
            foreach( $user->roles as $role ) {
                if( $role->id == $roleFind->id ) {
                    if( Auth::attempt($credentials, $remember) ){
                        $user->rol = $roleFind->id;
                        $user->save();
                        $request->session()->regenerate();
                        return redirect()->route("dashboard.index");
                    }
                }
            }
        }
        return redirect()->route("login")->with("info", "Credenciales inválidas");
    }

    public function profile() {
        $user = Auth::user();
        $title = "Mis Datos";
        return view("usuarios.show", compact("user", "title"));
    }

    public function logout() {
        Auth::logout();
        return redirect()->route("login");
    }
}
