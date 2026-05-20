<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TiendaController;
use App\Http\Controllers\Api\SuscripcionesController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\PagosuscripcioneController;
use App\Http\Controllers\Api\PagoordeneController;
use App\Http\Controllers\Api\OrdenitemController;
use App\Http\Controllers\Api\EmprendedoreController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\CarritoController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ResenaController;
use App\Http\Controllers\Api\PayPallController;
use App\Http\Controllers\Api\FinalizarCompraController;
use App\Http\Controllers\Api\ClienteDashboardController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::resource('/productos', ProductoController::class)
    ->only(['index', 'show'])
    ->names('api.productos');

Route::resource('/tiendas', TiendaController::class)
    ->only(['index', 'show'])
    ->names('api.tiendas');

Route::get('/productos/{id}/resenas', [ResenaController::class, 'index']);

Route::middleware('jwt')->group(function () {

    Route::get('/user', [AuthController::class, 'getUser']);
    Route::put('/user', [AuthController::class, 'updateUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::resource('/carritos', CarritoController::class);

    Route::post('/resenas', [ResenaController::class, 'store']);

    Route::post('/finalizar-compra', [FinalizarCompraController::class, 'store']);

    Route::get('/cliente/compras', [ClienteDashboardController::class, 'compras']);
    Route::get('/cliente/pagos', [ClienteDashboardController::class, 'pagos']);

    Route::get('/paypal/{amount}', [PayPallController::class, 'index']);
    Route::post('/paypal/create-order', [PayPallController::class, 'createOrder']);
    Route::post('/paypal/capture-order', [PayPallController::class, 'captureOrder']);

    Route::resource('/clientes', ClienteController::class);
    Route::resource('/ordenes', OrdenitemController::class);
    Route::resource('/pagoordene', PagoordeneController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/suscripciones', SuscripcionesController::class);
    Route::resource('/pagos', PagosuscripcioneController::class);

    Route::resource('/emprendedores', EmprendedoreController::class)
        ->names('api.emprendedores');

    Route::resource('/tiendas', TiendaController::class)
        ->except(['index', 'show'])
        ->names('api.tiendas.admin');

    Route::resource('/productos', ProductoController::class)
        ->except(['index', 'show'])
        ->names('api.productos.admin');
});