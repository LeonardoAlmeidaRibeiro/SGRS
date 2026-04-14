<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('painel.login');
Route::get('/cadastro', function () {
    return view('cadastro');
})->name('sgrs.cadastro');
