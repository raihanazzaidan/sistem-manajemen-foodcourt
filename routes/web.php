<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('stan', \App\Http\Controllers\Admin\StanController::class);
Route::resource('menu', \App\Http\Controllers\Penjual\MenuController::class);