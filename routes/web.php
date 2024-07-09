<?php

use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FuncionalidadController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\PagoFacilController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleFuncionalidadController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\TraspasoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get("/", [LoginController::class, "index"])->name("login")->middleware("guest");
Route::get("login", [LoginController::class, "index"])->name("login")->middleware("guest");

Route::post("login", [LoginController::class, "ingresar"])->name("login.ingresar");

Route::group(["middleware" => "auth"], function() {
    
    Route::get('/dashboard', [DashboardController::class, "index"])->name("dashboard.index");

    Route::get("login/profile", [LoginController::class, "profile"])->name("login.profile");
    
    Route::get("login/logout", 
        function(){ 
            return redirect()->route("dashboard.index"); 
        }
    )->name("login.logout");
    Route::post("login/logout", [LoginController::class, "logout"])->name("login.logout");
    

    Route::resource("users", UserController::class)->names("users");
    Route::post('users/buscar', [UserController::class, "buscar"]);
    Route::post('users/empleados', [UserController::class, "buscarEmpleados"]);
    Route::post('users/proveedores', [UserController::class, "buscarProveedores"]);
    Route::post('users/clientes', [UserController::class, "buscarClientes"]);
    Route::post('users/buscarForCI', [UserController::class, "buscarForCI"]);


    Route::resource("roles", RoleController::class)->names("roles");
    Route::post("roles/guardarNuevasFuncionalidades", [RoleController::class, "guardarNuevasFuncionalidades"])->name("roles.guardarNuevasFuncionalidades");

    Route::resource("roleFuncionalidades", RoleFuncionalidadController::class)->names("roleFuncionalidades");
    Route::post("roleFuncionalidades/guardarNuevosPermisos", [RoleFuncionalidadController::class, "guardarNuevosPermisos"])->name("roleFuncionalidades.guardarNuevosPermisos");

    // Route::resource("clientes", ClienteController::class)->names("clientes");
    // Route::post('clientes/buscar', [ClienteController::class, "buscar"]);

    Route::resource("sucursals", SucursalController::class)->names("sucursals");
    Route::post('sucursals/buscar', [SucursalController::class, "buscar"]);
    Route::post('sucursals/buscarById', [SucursalController::class, "buscarById"]);

    Route::resource("almacenes", AlmacenController::class)->names("almacenes");
    Route::post('almacenes/buscar', [AlmacenController::class, "buscar"]);
    Route::post('almacenes/buscarById', [AlmacenController::class, "buscarById"]);
    Route::post('almacenes/buscarAlmacenProductos', 
                [AlmacenController::class, "buscarAlmacenProductos"]
                );

    Route::resource("categorias", CategoriaController::class)->names("categorias");
    Route::post('categorias/buscar', [CategoriaController::class, "buscar"]);
    Route::post('categorias/buscarById', [CategoriaController::class, "buscarById"]);

    Route::resource("productos", ProductoController::class)->names("productos");
    Route::post('productos/buscar', [ProductoController::class, "buscar"]);
    Route::post('productos/buscarById', [ProductoController::class, "buscarById"]);
    Route::post('productos/buscarByName', [ProductoController::class, "buscarByName"]);

    Route::resource("compras", CompraController::class)->names("compras");
    Route::post('compras/guardarCompra', [CompraController::class, "guardarCompra"]);
    Route::post('compras/buscar', [CompraController::class, "buscar"]);


    Route::resource("movimientos", MovimientoController::class)->names("movimientos");
    Route::post('movimientos/buscar', [MovimientoController::class, "buscar"]);

    Route::resource("traspasos", TraspasoController::class)->names("traspasos");
    Route::post('traspasos/detalleTraspaso', [TraspasoController::class, "detalleTraspaso"]);
    Route::post('traspasos/guardarTraspaso', [TraspasoController::class, "guardarTraspaso"]);
    Route::post('traspasos/buscar', [TraspasoController::class, "buscar"]);

    Route::resource("ventas", VentaController::class)->names("ventas");
    Route::post('ventas/buscar', [VentaController::class, "buscar"]);
    Route::post('ventas/pagarCarrito', [VentaController::class, "pagarCarrito"]);
    Route::post('ventas/createCarrito', [VentaController::class, "createCarrito"])->name("ventas.createCarrito");
    Route::get("ventas/generatePdf/{id}", [VentaController::class, "facturaToPdf"])->name("ventas.generatePdf");
    Route::post("ventas/pagoEfectivo/{id}", [VentaController::class, "pagoEfectivo"])->name("ventas.pagoEfectivo");

    Route::post("pagofacil/generarQR", [ PagoFacilController::class, "generarQR"]);
    Route::post("pagofacil/consultarEstado", [ PagoFacilController::class, "consultarEstado"]);
    
    Route::middleware(["can:view-any"])->group(function() {
        Route::get("temas", function() { return view("temas"); })->name("temas.index");
    });
    Route::resource("modulos", ModuloController::class)->names("modulos");
    Route::resource("funcionalidades", FuncionalidadController::class)->names("funcionalidades");
    Route::post("funcionalidades/buscarByName", [ FuncionalidadController::class, "buscarFuncionalidad"]);
    Route::resource("permisos", PermisoController::class)->names("permisos");

    //-----------------Gráficos
    Route::post("categorias/cantidadProductos", [ CategoriaController::class, "cantidadProductos"]);

});