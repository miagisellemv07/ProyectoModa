<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmprendedorController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dash.home');
    })->name('dashboard');

    Route::middleware(['role:admin'])->group(function () {

        Route::resource('/dashboard/usuarios', UserController::class)
            ->names('usuarios');

        Route::resource('/dashboard/emprendedores', EmprendedorController::class)
            ->names('emprendedores');

        Route::resource('/dashboard/tiendas', TiendaController::class)
            ->names('tiendas');
    });

    Route::middleware(['role:emprendedor'])->group(function () {

        Route::resource('/dashboard/productos', ProductoController::class)
            ->names('productos');

        Route::get('/dashboard/pedidos', function () {
            return view('dash.pedidos');
        })->name('dashboard.pedidos');

        Route::get('/dashboard/pagos', function () {
            return view('dash.pagos');
        })->name('dashboard.pagos');
    });

    Route::middleware(['role:cliente'])->group(function () {
        Route::get('/dashboard/compras', function () {
            return view('dash.compras');
        })->name('dashboard.compras');

        Route::get('/dashboard/mis-pagos', function () {
            return view('dash.mis_pagos');
        })->name('dashboard.mis_pagos');
    });
});