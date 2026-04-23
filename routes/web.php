<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LoginController,
    ClassificacaoResiduoController,
    UnidadeMedidaController,
    ResiduoController
};

Route::get('/', [LoginController::class, 'login'])->name('painel.login');
Route::get('/cadastro', [LoginController::class, 'cadastro'])->name('painel.cadastro');
Route::post('/cadastro-empresa', [LoginController::class, 'store'])->name('empresa.store');
Route::post('/login', [LoginController::class, 'access'])->name('painel.access'); //corrigir 
Route::post('/logout', [LoginController::class, 'logout'])->name('painel.logout');

Route::get('/painel/unidades-medida', [UnidadeMedidaController::class, 'index'])->name('unidades-medida.index');
Route::post('/painel/unidades-medida', [UnidadeMedidaController::class, 'store'])->name('unidades-medida.store');
Route::put('/painel/unidades-medida/{id?}', [UnidadeMedidaController::class, 'update'])->name('unidades-medida.update');
Route::delete('/painel/unidades-medida/{id?}', [UnidadeMedidaController::class, 'destroy'])->name('unidades-medida.destroy');

Route::get('/painel/classificacoes-residuo', [ClassificacaoResiduoController::class, 'index'])->name('classificacoes-residuo.index');
Route::post('/painel/classificacoes-residuo', [ClassificacaoResiduoController::class, 'store'])->name('classificacoes-residuo.store');
Route::put('/painel/classificacoes-residuo/{id}', [ClassificacaoResiduoController::class, 'update'])->name('classificacoes-residuo.update');
Route::delete('/painel/classificacoes-residuo/{id}', [ClassificacaoResiduoController::class, 'destroy'])->name('classificacoes-residuo.destroy');
Route::get('/painel/classificacoes-residuo/{id}', [ClassificacaoResiduoController::class, 'show'])->name('classificacoes-residuo.show');



Route::get('/painel/residuos', [ResiduoController::class, 'index'])->name('residuos.index');
Route::post('/painel/residuos', [ResiduoController::class, 'store'])->name('residuos.store');
Route::put('/painel/residuos/{id}', [ResiduoController::class, 'update'])->name('residuos.update');
Route::delete('/painel/residuos/{id}', [ResiduoController::class, 'destroy'])->name('residuos.destroy');
Route::get('/painel/residuos/{id}', [ResiduoController::class, 'show'])->name('residuos.show');
Route::patch('/painel/residuos/{id}/status', [ResiduoController::class, 'updateStatus'])->name('residuos.updateStatus');
Route::get('/painel/residuos/localizacao/buscar', [ResiduoController::class, 'getByLocation'])->name('residuos.getByLocation');
Route::get('/painel/estatisticas/residuos', [ResiduoController::class, 'getStatistics'])->name('residuos.statistics');

Route::get('/home', function () {
    return view('painel.home');
})->name('painel.home')->middleware('auth');

Route::get('/teste', function () {
    return ('olá mundo');
});
