<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', [LoginController::class, 'login'])->name('painel.login');
Route::get('/cadastro', [LoginController::class, 'cadastro'])->name('painel.cadastro');
Route::get('/buscar-cidade', [LoginController::class, 'buscarPorNome'])->name('buscar.cidade');

Route::get('/teste', function () {
    return ('olá mundo');
});