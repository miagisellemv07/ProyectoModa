<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TiendaController;
Route::resource('/users',UserController::class);
Route::resource('/tiendas',TiendaController::class);
