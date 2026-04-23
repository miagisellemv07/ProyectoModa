<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TiendaController;
use App\Http\Controllers\Api\SuscripcionesController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\PagosuscripcioneController;


Route::resource('/users',UserController::class);
Route::resource('/tiendas',TiendaController::class);
Route::resource('/suscripciones',SuscripcionesController::class);
Route::resource('/productos',ProductoController::class);
Route::resource('/pagos',PagosuscripcioneController::class);
