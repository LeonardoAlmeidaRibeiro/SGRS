<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', [LoginController::class, 'login'])->name('painel.login');
Route::get('/cadastro', [LoginController::class, 'cadastro'])->name('painel.cadastro');
Route::post('/cadastro-empresa', [LoginController::class, 'store'])->name('empresa.store');
Route::post('/login', [LoginController::class, 'access'])->name('painel.access');//corrigir 
Route::post('/logout', [LoginController::class, 'logout'])->name('painel.logout');

Route::get('/home', function () {
    return view('painel.home');
})->name('painel.home')->middleware('auth');

Route::get('/teste', function () {
    return ('olá mundo');
});