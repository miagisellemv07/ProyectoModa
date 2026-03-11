<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dash.home');
})->name('dashboard');

Route::get('/admin/users', function () {
    return view('dash.users');
})->name('dashboard.users');