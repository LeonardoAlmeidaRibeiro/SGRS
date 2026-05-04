<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LoginController,
    ClassificacaoResiduoController,
    MarketplaceController,
    PerfilController,
    UnidadeMedidaController,
    ResiduoController
};

Route::get('/', [LoginController::class, 'login'])->name('painel.login');
Route::get('/cadastro', [LoginController::class, 'cadastro'])->name('painel.cadastro');
Route::post('/cadastro-empresa', [LoginController::class, 'store'])->name('empresa.store');
Route::post('/login', [LoginController::class, 'access'])->name('painel.access'); 
Route::post('/logout', [LoginController::class, 'logout'])->name('painel.logout');

Route::middleware('auth')->group(function () {
    Route::get('/painel/meu-perfil', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/painel/meu-perfil/dados-pessoais', [PerfilController::class, 'updateDadosPessoais'])->name('perfil.dados-pessoais.update');
    Route::put('/painel/meu-perfil/endereco', [PerfilController::class, 'updateEndereco'])->name('perfil.endereco.update');
});

Route::get('/painel/unidades-medida', [UnidadeMedidaController::class, 'index'])->name('unidades-medida.index');
Route::post('/painel/unidades-medida', [UnidadeMedidaController::class, 'store'])->name('unidades-medida.store');
Route::put('/painel/unidades-medida/{id}', [UnidadeMedidaController::class, 'update'])->name('unidades-medida.update');
Route::delete('/painel/unidades-medida/{id}', [UnidadeMedidaController::class, 'destroy'])->name('unidades-medida.destroy');

Route::get('/painel/classificacoes-residuo', [ClassificacaoResiduoController::class, 'index'])->name('classificacoes-residuo.index');
Route::post('/painel/classificacoes-residuo', [ClassificacaoResiduoController::class, 'store'])->name('classificacoes-residuo.store');
Route::put('/painel/classificacoes-residuo/{id}', [ClassificacaoResiduoController::class, 'update'])->name('classificacoes-residuo.update');
Route::delete('/painel/classificacoes-residuo/{id}', [ClassificacaoResiduoController::class, 'destroy'])->name('classificacoes-residuo.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/painel/marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
    Route::get('/painel/marketplace/{id}', [MarketplaceController::class, 'show'])->name('marketplace.show');
    Route::post('/painel/marketplace/{id}/reservar', [MarketplaceController::class, 'reservar'])->name('marketplace.reservar');

    Route::get('/painel/residuos', [ResiduoController::class, 'index'])->name('residuos.index');
    Route::get('/painel/residuos/criar', [ResiduoController::class, 'create'])->name('residuos.create');
    Route::post('/painel/residuos', [ResiduoController::class, 'store'])->name('residuos.store');
    Route::get('/painel/residuos/localizacao/buscar', [ResiduoController::class, 'getByLocation'])->name('residuos.getByLocation');
    Route::get('/painel/estatisticas/residuos', [ResiduoController::class, 'getStatistics'])->name('residuos.statistics');
    Route::get('/painel/residuos/{id}', [ResiduoController::class, 'show'])->name('residuos.show');
    Route::get('/painel/residuos/{id}/editar', [ResiduoController::class, 'edit'])->name('residuos.edit');
    Route::put('/painel/residuos/{id}', [ResiduoController::class, 'update'])->name('residuos.update');
    Route::delete('/painel/residuos/{id}', [ResiduoController::class, 'destroy'])->name('residuos.destroy');
    Route::patch('/painel/residuos/{id}/status', [ResiduoController::class, 'updateStatus'])->name('residuos.updateStatus');
});

Route::get('/painel/home', function () {
    return view('painel.home');
})->name('painel.home')->middleware('auth');

Route::get('/teste', function () {
    return ('olá mundo');
});
