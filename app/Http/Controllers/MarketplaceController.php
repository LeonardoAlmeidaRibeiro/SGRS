<?php

namespace App\Http\Controllers;

use App\Models\ClassificacaoResiduo;
use App\Models\Residuo;
use App\Models\Transacao;
use App\Services\ImpactoCalculatorService;
use App\Services\MatchInteligenteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $query = Residuo::with(['empresa', 'classificacao', 'unidade'])
            ->where('residuos.status', 'disponivel');

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

        $residuos = $query->orderBy('residuos.created_at', 'desc')->paginate(12)->withQueryString();
        $classificacoes = ClassificacaoResiduo::orderBy('nome')->get();

        return view('painel.marketplace.index', compact('residuos', 'classificacoes'));
    }

    public function show($id, MatchInteligenteService $matchService)
    {
        $residuo = Residuo::with(['empresa', 'classificacao', 'unidade'])
            ->where('residuos.status', 'disponivel')
            ->find($id);

        if (!$residuo) {
            return redirect()
                ->route('marketplace.index')
                ->with('swal_error', 'Resíduo não encontrado ou indisponível.');
        }

        $matches = $matchService->recomendarParaResiduo($residuo);

        return view('painel.marketplace.visualizar', compact('residuo', 'matches'));
    }

    public function reservar($id, ImpactoCalculatorService $impactoService)
    {
        $residuo = Residuo::where('residuos.status', 'disponivel')->find($id);

        if (!$residuo) {
            return redirect()
                ->route('marketplace.index')
                ->with('swal_error', 'Este resíduo não está mais disponível.');
        }

        if (Auth::check() && (int) $residuo->empresa_id === (int) Auth::user()->empresa_id) {
            return redirect()
                ->route('marketplace.show', $residuo->id)
                ->with('swal_error', 'Sua empresa já é a responsável por este resíduo.');
        }

        try {
            DB::beginTransaction();

            $transacao = Transacao::create([
                'residuo_id' => $residuo->id,
                'empresa_origem_id' => $residuo->empresa_id,
                'empresa_destino_id' => Auth::user()->empresa_id,
                'status' => 'pendente',
                'data_transacao' => now()->toDateString(),
            ]);

            $residuo->update(['status' => 'reservado']);
            $transacao->impacto()->create($impactoService->calcular($transacao));

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
