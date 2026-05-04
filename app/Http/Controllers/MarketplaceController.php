<?php

namespace App\Http\Controllers;

use App\Models\ClassificacaoResiduo;
use App\Models\Residuo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $query = Residuo::with(['empresa', 'classificacao', 'unidade'])
            ->where('status', 'disponivel');

        if ($request->filled('tipo_material')) {
            $query->where('tipo_material', 'like', '%' . $request->tipo_material . '%');
        }

        if ($request->filled('classificacao_id')) {
            $query->where('classificacao_id', $request->classificacao_id);
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
            $query->where('quantidade', '>=', $request->quantidade_min);
        }

        if ($request->filled('quantidade_max')) {
            $query->where('quantidade', '<=', $request->quantidade_max);
        }

        if ($request->filled('cidade')) {
            $query->where('cidade', 'like', '%' . $request->cidade . '%');
        }

        if ($request->filled('estado')) {
            $query->where('estado', strtoupper($request->estado));
        }

        $residuos = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();
        $classificacoes = ClassificacaoResiduo::orderBy('nome')->get();

        return view('painel.marketplace.index', compact('residuos', 'classificacoes'));
    }

    public function show($id)
    {
        $residuo = Residuo::with(['empresa', 'classificacao', 'unidade'])
            ->where('status', 'disponivel')
            ->find($id);

        if (!$residuo) {
            return redirect()
                ->route('marketplace.index')
                ->with('swal_error', 'Resíduo não encontrado ou indisponível.');
        }

        return view('painel.marketplace.visualizar', compact('residuo'));
    }

    public function reservar($id)
    {
        $residuo = Residuo::where('status', 'disponivel')->find($id);

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

        $residuo->update(['status' => 'reservado']);

        return redirect()
            ->route('marketplace.index')
            ->with('swal_success', 'Resíduo reservado com sucesso! A empresa responsável poderá dar continuidade à negociação.');
    }
}
