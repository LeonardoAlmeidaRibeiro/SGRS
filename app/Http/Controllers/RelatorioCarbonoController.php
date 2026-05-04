<?php

namespace App\Http\Controllers;

use App\Models\Transacao;
use App\Services\CalculoCarbonoService;
use Illuminate\Http\Request;

class RelatorioCarbonoController extends Controller
{
    public function index(Request $request, CalculoCarbonoService $calculoCarbonoService)
    {
        $query = Transacao::with(['residuo.unidade', 'empresaOrigem', 'empresaDestino'])
            ->where('status', '!=', 'cancelado');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('data_transacao', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data_transacao', '<=', $request->data_fim);
        }

        $transacoes = $query->latest()->get();

        $linhas = $transacoes->map(function (Transacao $transacao) use ($calculoCarbonoService) {
            $impacto = $calculoCarbonoService->calcularPorTransacao($transacao);
            $residuo = $transacao->residuo;

            return [
                'transacao' => $transacao,
                'tipo_material' => optional($residuo)->tipo_material,
                'quantidade' => optional($residuo)->quantidade,
                'unidade' => optional(optional($residuo)->unidade)->nome,
                'impacto' => $impacto,
            ];
        });

        $totais = [
            'co2_economizado' => $linhas->sum('impacto.co2_economizado'),
            'agua_economizada' => $linhas->sum('impacto.agua_economizada'),
            'energia_economizada' => $linhas->sum('impacto.energia_economizada'),
            'valor_economizado' => $linhas->sum('impacto.valor_economizado'),
        ];

        return view('painel.relatorios_carbono.index', compact('linhas', 'totais'));
    }
}
