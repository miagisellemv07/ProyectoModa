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

Route::resource('/carritos', CarritoController::class);
Route::resource('/clientes', ClienteController::class);
Route::resource('/ordenes', OrdenitemController::class);
Route::resource('/pagoordene', PagoordeneController::class);
Route::resource('/users', UserController::class);
Route::resource('/suscripciones', SuscripcionesController::class);
Route::resource('/pagos', PagosuscripcioneController::class);

Route::resource('/emprendedores', EmprendedoreController::class)
    ->names('api.emprendedores');

Route::resource('/tiendas', TiendaController::class)
    ->names('api.tiendas');

Route::resource('/productos', ProductoController::class)
    ->names('api.productos');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| PayPal
|--------------------------------------------------------------------------
*/
Route::get('/paypal/{amount}', [PayPallController::class, 'index']);
Route::post('/paypal/create-order', [PayPallController::class, 'createOrder']);
Route::post('/paypal/capture-order', [PayPallController::class, 'captureOrder']);

/*
|--------------------------------------------------------------------------
| Reseñas públicas
|--------------------------------------------------------------------------
*/
Route::get('/productos/{id}/resenas', [ResenaController::class, 'index']);

Route::middleware('jwt')->group(function () {

    Route::get('/user', [AuthController::class, 'getUser']);
    Route::put('/user', [AuthController::class, 'updateUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/resenas', [ResenaController::class, 'store']);
});