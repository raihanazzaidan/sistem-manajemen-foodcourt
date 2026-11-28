<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Frontend login & registrasi 
Route::view('/masuk', 'autentikasi.masuk')->name('login');
Route::view('/daftar-stand', 'autentikasi.daftar-penjual')->name('daftar.penjual');
Route::get('/status-pendaftaran/{status?}', fn (string $status = 'terkirim') => view('penjual.status-pendaftaran', compact('status')))
    ->whereIn('status', ['terkirim', 'menunggu', 'revisi', 'ditolak', 'disetujui'])
    ->name('penjual.status-pendaftaran');

Route::resource('stan', \App\Http\Controllers\Admin\StanController::class);
Route::resource('menu', \App\Http\Controllers\Penjual\MenuController::class);