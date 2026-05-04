<?php

namespace App\Http\Controllers;

use App\Models\ClassificacaoResiduo;
use App\Models\Residuo;
use App\Models\Transacao;
use App\Services\ImpactoCalculatorService;
use App\Services\MatchInteligenteService;
use App\Services\RastreabilidadeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $query = Residuo::with(['empresa', 'classificacao', 'unidade'])
            ->where('residuos.status', 'disponivel')
            ->where('residuos.documentacao_validada', true)
            ->where(function ($docs) {
                $docs->whereNotNull('residuos.mtr_url')
                    ->orWhereNotNull('residuos.licenca_ambiental_url');
            });

        if (Auth::check() && Auth::user()->empresa_id) {
            $query->where('residuos.empresa_id', '!=', Auth::user()->empresa_id);
        }

        if ($request->filled('tipo_material')) {
            $query->where('residuos.tipo_material', 'like', '%' . $request->tipo_material . '%');
        }

        if ($request->filled('classificacao_id')) {
            $query->where('residuos.classificacao_id', $request->classificacao_id);
        }

        if ($request->filled('periculosidade')) {
            $query->whereHas('classificacao', function ($classificacao) use ($request) {
                if ($request->periculosidade === 'controlado') {
                    $classificacao->where(function ($q) {
                        $q->where('exige_mtr', true)->orWhere('exige_cadri', true);
                    });
                }

                if ($request->periculosidade === 'comum') {
                    $classificacao->where('exige_mtr', false)->where('exige_cadri', false);
                }
            });
        }

        if ($request->filled('quantidade_min')) {
            $query->where('residuos.quantidade', '>=', $request->quantidade_min);
        }

        if ($request->filled('quantidade_max')) {
            $query->where('residuos.quantidade', '<=', $request->quantidade_max);
        }

        if ($request->filled('cidade')) {
            $query->where('residuos.cidade', 'like', '%' . $request->cidade . '%');
        }

        if ($request->filled('estado')) {
            $query->where('residuos.estado', strtoupper($request->estado));
        }

        if ($request->boolean('somente_reputadas')) {
            $query->whereHas('empresa', function ($empresa) {
                $empresa->where('restrita_por_reputacao', false)
                    ->where(function ($q) {
                        $q->where('reputacao_media', '>=', 3)
                            ->orWhere('reputacao_media', 0);
                    })
                    ->where('taxa_conformidade', '>=', 80);
            });
        }

        $residuos = $query->orderBy('residuos.created_at', 'desc')->paginate(12)->withQueryString();
        $classificacoes = ClassificacaoResiduo::orderBy('nome')->get();
        $empresaLogada = optional(Auth::user())->empresa;

        return view('painel.marketplace.index', compact('residuos', 'classificacoes', 'empresaLogada'));
    }

    public function show($id, MatchInteligenteService $matchService)
    {
        $residuo = Residuo::with(['empresa', 'classificacao', 'unidade'])
            ->where('residuos.status', 'disponivel')
            ->where('residuos.documentacao_validada', true)
            ->find($id);

        if (!$residuo) {
            return redirect()
                ->route('marketplace.index')
                ->with('swal_error', 'Resíduo não encontrado ou indisponível.');
        }

        $matches = $matchService->recomendarParaResiduo($residuo);

        $empresaLogada = optional(Auth::user())->empresa;

        return view('painel.marketplace.visualizar', compact('residuo', 'matches', 'empresaLogada'));
    }

    public function reservar($id, ImpactoCalculatorService $impactoService, RastreabilidadeService $rastreabilidadeService)
    {
        $residuo = Residuo::with(['classificacao', 'empresa'])
            ->where('residuos.status', 'disponivel')
            ->where('residuos.documentacao_validada', true)
            ->find($id);

        if (!$residuo) {
            return redirect()
                ->route('marketplace.index')
                ->with('swal_error', 'Este resíduo não está mais disponível.');
        }

        $empresaDestino = optional(Auth::user())->empresa;

        if (!$empresaDestino) {
            return redirect()
                ->route('marketplace.show', $residuo->id)
                ->with('swal_error', 'Seu usuario precisa estar vinculado a uma empresa para registrar interesse.');
        }

        if (Auth::check() && (int) $residuo->empresa_id === (int) Auth::user()->empresa_id) {
            return redirect()
                ->route('marketplace.show', $residuo->id)
                ->with('swal_error', 'Sua empresa já é a responsável por este resíduo.');
        }

        if ($empresaDestino->restrita_por_reputacao || ((float) $empresaDestino->reputacao_media > 0 && (float) $empresaDestino->reputacao_media < 3)) {
            return redirect()
                ->route('marketplace.show', $residuo->id)
                ->with('swal_error', 'Sua empresa esta com restricao por reputacao baixa e nao pode reservar novos residuos no momento.');
        }

        if (optional($residuo->classificacao)->eh_perigoso && !$empresaDestino->podeReceberResiduoPerigoso()) {
            return redirect()
                ->route('marketplace.show', $residuo->id)
                ->with('swal_error', 'Residuo perigoso so pode ser transferido para empresas com licenca ambiental especifica valida.');
        }

        try {
            DB::beginTransaction();

            $dadosTransacao = $rastreabilidadeService->prepararTransacao([
                'residuo_id' => $residuo->id,
                'empresa_origem_id' => $residuo->empresa_id,
                'empresa_destino_id' => $empresaDestino->id,
                'status' => 'pendente',
                'data_transacao' => now()->toDateString(),
            ]);

            $transacao = Transacao::create($dadosTransacao);

            $residuo->update(['status' => 'reservado']);
            $transacao->impacto()->create($impactoService->calcular($transacao));
            $rastreabilidadeService->registrar($transacao, 'interesse_registrado', 'Empresa destino registrou interesse pelo residuo.', $residuo->mtr_url ?: $residuo->licenca_ambiental_url);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('marketplace.index')
                ->with('swal_error', 'Erro ao registrar interesse: ' . $e->getMessage());
        }

        return redirect()
            ->route('marketplace.index')
            ->with('swal_success', 'Interesse registrado com sucesso! Uma transação pendente foi criada para continuidade da negociação.');
    }
}
