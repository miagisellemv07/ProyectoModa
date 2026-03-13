<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Auth::routes();

/*
|--------------------------------------------------------------------------
| Dashboard general para todos los usuarios autenticados
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dash.home');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Rutas del administrador
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->group(function () {

        Route::resource('/dashboard/usuarios', \App\Http\Controllers\UserController::class)
            ->names('usuarios');

        Route::get('/dashboard/clientes', function () {
            return view('dash.clientes');
        })->name('dashboard.clientes');

        Route::get('/dashboard/tiendas', function () {
            return view('dash.tiendas');
        })->name('dashboard.tiendas');
    });

    /*
    |--------------------------------------------------------------------------
    | Rutas del emprendedor
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:emprendedor'])->group(function () {
        Route::get('/dashboard/productos', function () {
            return view('dash.productos');
        })->name('dashboard.productos');

        Route::get('/dashboard/pedidos', function () {
            return view('dash.pedidos');
        })->name('dashboard.pedidos');

        Route::get('/dashboard/pagos', function () {
            return view('dash.pagos');
        })->name('dashboard.pagos');
    });

    /*
    |--------------------------------------------------------------------------
    | Rutas del cliente
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:cliente'])->group(function () {
        Route::get('/dashboard/compras', function () {
            return view('dash.compras');
        })->name('dashboard.compras');

        Route::get('/dashboard/mis-pagos', function () {
            return view('dash.mis_pagos');
        })->name('dashboard.mis_pagos');
    });
});