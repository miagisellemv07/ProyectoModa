<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Auth::routes();

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', function () {
        return view('dash.users');
    })->name('dashboard.users');
});