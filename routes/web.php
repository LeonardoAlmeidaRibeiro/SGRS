<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LoginController,
    AvaliacaoController,
    ClassificacaoResiduoController,
    DashboardSustentavelController,
    DocumentoTransacaoController,
    ImpactoController,
    InteresseController,
    MarketplaceController,
    PerfilController,
    RelatorioCarbonoController,
    TransacaoController,
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
    Route::get('/painel/dashboard-sustentavel', [DashboardSustentavelController::class, 'index'])->name('dashboard-sustentavel.index');
    Route::get('/painel/relatorio-carbono', [RelatorioCarbonoController::class, 'index'])->name('relatorio-carbono.index');

    Route::get('/painel/interesses', [InteresseController::class, 'index'])->name('interesses.index');
    Route::get('/painel/interesses/criar', [InteresseController::class, 'create'])->name('interesses.create');
    Route::post('/painel/interesses', [InteresseController::class, 'store'])->name('interesses.store');
    Route::get('/painel/interesses/{interesse}', [InteresseController::class, 'show'])->name('interesses.show');
    Route::get('/painel/interesses/{interesse}/editar', [InteresseController::class, 'edit'])->name('interesses.edit');
    Route::put('/painel/interesses/{interesse}', [InteresseController::class, 'update'])->name('interesses.update');
    Route::delete('/painel/interesses/{interesse}', [InteresseController::class, 'destroy'])->name('interesses.destroy');

    Route::get('/painel/transacoes', [TransacaoController::class, 'index'])->name('transacoes.index');
    Route::get('/painel/transacoes/criar', [TransacaoController::class, 'create'])->name('transacoes.create');
    Route::post('/painel/transacoes', [TransacaoController::class, 'store'])->name('transacoes.store');
    Route::get('/painel/transacoes/{transacao}', [TransacaoController::class, 'show'])->name('transacoes.show');
    Route::get('/painel/transacoes/{transacao}/editar', [TransacaoController::class, 'edit'])->name('transacoes.edit');
    Route::put('/painel/transacoes/{transacao}', [TransacaoController::class, 'update'])->name('transacoes.update');
    Route::delete('/painel/transacoes/{transacao}', [TransacaoController::class, 'destroy'])->name('transacoes.destroy');

    Route::get('/painel/documentos-transacao', [DocumentoTransacaoController::class, 'index'])->name('documentos-transacao.index');
    Route::get('/painel/documentos-transacao/criar', [DocumentoTransacaoController::class, 'create'])->name('documentos-transacao.create');
    Route::post('/painel/documentos-transacao', [DocumentoTransacaoController::class, 'store'])->name('documentos-transacao.store');
    Route::get('/painel/documentos-transacao/{documentoTransacao}', [DocumentoTransacaoController::class, 'show'])->name('documentos-transacao.show');
    Route::get('/painel/documentos-transacao/{documentoTransacao}/editar', [DocumentoTransacaoController::class, 'edit'])->name('documentos-transacao.edit');
    Route::put('/painel/documentos-transacao/{documentoTransacao}', [DocumentoTransacaoController::class, 'update'])->name('documentos-transacao.update');
    Route::delete('/painel/documentos-transacao/{documentoTransacao}', [DocumentoTransacaoController::class, 'destroy'])->name('documentos-transacao.destroy');

    Route::get('/painel/impactos', [ImpactoController::class, 'index'])->name('impactos.index');
    Route::get('/painel/impactos/criar', [ImpactoController::class, 'create'])->name('impactos.create');
    Route::post('/painel/impactos', [ImpactoController::class, 'store'])->name('impactos.store');
    Route::get('/painel/impactos/{impacto}/editar', [ImpactoController::class, 'edit'])->name('impactos.edit');
    Route::put('/painel/impactos/{impacto}', [ImpactoController::class, 'update'])->name('impactos.update');
    Route::delete('/painel/impactos/{impacto}', [ImpactoController::class, 'destroy'])->name('impactos.destroy');
    Route::post('/painel/impactos/calcular/{transacao}', [ImpactoController::class, 'calcular'])->name('impactos.calcular');
    Route::get('/painel/avaliacoes', [AvaliacaoController::class, 'index'])->name('avaliacoes.index');
    Route::get('/painel/avaliacoes/criar', [AvaliacaoController::class, 'create'])->name('avaliacoes.create');
    Route::post('/painel/avaliacoes', [AvaliacaoController::class, 'store'])->name('avaliacoes.store');
    Route::get('/painel/avaliacoes/{avaliacao}/editar', [AvaliacaoController::class, 'edit'])->name('avaliacoes.edit');
    Route::put('/painel/avaliacoes/{avaliacao}', [AvaliacaoController::class, 'update'])->name('avaliacoes.update');
    Route::delete('/painel/avaliacoes/{avaliacao}', [AvaliacaoController::class, 'destroy'])->name('avaliacoes.destroy');

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
