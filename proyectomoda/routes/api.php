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

Route::resource('/carritos', CarritoController::class);
Route::resource('/clientes', ClienteController::class);
Route::resource('/emprendedores', EmprendedoreController::class);
Route::resource('/ordenes', OrdenitemController::class);
Route::resource('/pagoordene', PagoordeneController::class);
Route::resource('/users',UserController::class);
Route::resource('/tiendas',TiendaController::class);
Route::resource('/suscripciones',SuscripcionesController::class);
Route::resource('/productos',ProductoController::class);
Route::resource('/pagos',PagosuscripcioneController::class);
