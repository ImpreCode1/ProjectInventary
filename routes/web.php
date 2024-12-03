<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\InfoMovimientoController;
use App\Http\Controllers\MovimientoProductoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Models\InfoMovimiento;
use App\Models\MovimientoProducto;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//ruta inicio de sesion
Route::view('/', 'login')->name('login');

Route::prefix('auth')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login/verify', [AuthController::class, 'loginverify'])->name('login.verify');
    Route::get('logout', [AuthController::class, 'signout'])->name('logout');
    Route::post('logout', [AuthController::class, 'signout'])->name('logouts');
});

//rutas login
Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        $user = Auth::user();
        $userNombres = session('user_nombres');
        $userApellidos = session('user_apellidos');
        $userImagen = session('user_imagen');
        $userRol = session('user_rol');

        if ($user->rol == 'Administrador') {
            return view('landing.landing', compact('userNombres', 'userApellidos', 'userImagen', 'userRol'));
        } elseif ($user->rol == 'Usuario') {
            return view('landing.landinguser', compact('userNombres', 'userApellidos', 'userImagen', 'userRol'));
        }
    })->name('dashboard');

    Route::middleware(['admin'])->group(function () {
        Route::view('/landing', '/landing/landing')->name('landing');
        Route::view('/productos', 'productos')->name('productos');
        Route::view('/stock', 'stock')->name('stock');
        // modal de edicion
        Route::view('/edicionproductos', 'edicionproductos')->name('edicionproductos');

        // rutas admin
        //creacion de usuario
        Route::post('/landing/store', [UsuarioController::class, 'store'])->name('usuario.store');

        // listar usuarios
        Route::get('/usuarios', [UsuarioController::class, 'show'])->name('usuarios');
        Route::delete('usuario/destroy/{usuario}', [UsuarioController::class, 'destroy'])->name('usuario.destroy');

        //ruta categoria
        Route::post('/categoria/store', [CategoriaController::class, 'store'])->name('categoria.store');
        Route::get('/categorias', [CategoriaController::class, 'show'])->name('categorias');
        Route::delete('categoria/delete/{categoria}', [CategoriaController::class, 'delete'])->name('categoria.delete');
        Route::post('categoria/agregarmedida', [CategoriaController::class, 'agregarmedida'])->name('categoria.agregarmedida');

        //ruta productos
        Route::post('producto/store', [ProductoController::class, 'store'])->name('producto.store');
        Route::get('/productos', [ProductoController::class, 'index'])->name('productos');
        // Route::get('/productos', 'ProductoController@index')->name('productos');
        Route::delete('producto/destroy/{producto}', [ProductoController::class, 'destroy'])->name('producto.destroy');
        Route::get('/productos/{producto}/edit', [ProductoController::class, 'edit'])->name('producto.edit');
        Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('producto.update');

        //ruta de reportes
        Route::get('/reportes', [ProductoController::class, 'mostrarMovimiento'])->name('reportes');
        // ruta de reportes excel
        Route::get('/reportes/export', [ProductoController::class, 'export'])->name('reportes.export');
        Route::delete('/reportes/destroy/{movimientoProducto}', [MovimientoProductoController::class, 'destroy'])->name('reportes.destroy');

        // ruta stock de productos
        Route::get('/stock', [ProductoController::class, 'verstock'])->name('stock');
        Route::get('/stock/exportproducto', [ProductoController::class, 'exportproducto'])->name('stock.exportproducto');

        // editar perfil 
        Route::get('/admin/perfil/{usuario}/edit', [UsuarioController::class, 'edit'])->name('admin.perfil.edit');
        Route::put('/admin/perfil/{usuario}', [UsuarioController::class, 'update'])->name('admin.perfil.update');
    });

    Route::middleware(['user'])->group(function () {
        //rutas landing
        Route::view('/landinguser', '/landing/landinguser')->name('landinguser');

        // rutas menu

        Route::view('/formulario', 'formulario')->name('formulario');
        Route::view('/verproductos', 'verproductos')->name('verproductos');

        // rutas user
        // ruta de movimiento de productos
        Route::get('/verproductos', [ProductoController::class, 'verinfoproducto'])->name('verproductos');
        Route::post('/formulario/{id}/movimiento', [ProductoController::class, 'realizarMovimiento'])->name('formulario.realizar-movimiento');
        Route::get('/formulario/{id}', [ProductoController::class, 'mostrarFormulario'])->name('formulario');

        // Route::get('/perfil', [UsuarioController::class, 'mostrarPerfil'])->name('perfil');
        Route::get('/perfil/{usuario}/edit', [UsuarioController::class, 'edit'])->name('perfil.edit');
        Route::put('/perfil/{usuario}', [UsuarioController::class, 'update'])->name('perfil.update');
    });
});

// Route::get('/perfiladmin/{usuario}/edit', [UsuarioController::class, 'edit'])->name('perfiladmin.edit');
// Route::put('/perfiladmin/{usuario}', [UsuarioController::class, 'update'])->name('perfiladmin.update');
// Route::get('/productos/{producto}/edit', [ProductoController::class, 'edit'])->name('producto.edit');
// Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('producto.update');
// Route::get('/partials/sidebar2/{usuario}/edit', [UsuarioController::class, 'edit'])->name('sidebar2.edit');



// Route::view('/perfil')->name('perfil');
