<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Impacto;
use App\Models\Residuo;
use App\Models\Transacao;
use Illuminate\Support\Facades\DB;

class DashboardSustentavelController extends Controller
{
    public function index()
    {
        $indicadores = [
            'residuos_disponiveis' => Residuo::where('status', 'disponivel')->count(),
            'transacoes_concluidas' => Transacao::where('status', 'concluido')->count(),
            'quantidade_reaproveitada' => Transacao::where('transacoes.status', 'concluido')
                ->join('residuos', 'residuos.id', '=', 'transacoes.residuo_id')
                ->sum('residuos.quantidade'),
            'co2_economizado' => Impacto::sum('co2_economizado'),
            'agua_economizada' => Impacto::sum('agua_economizada'),
            'energia_economizada' => Impacto::sum('energia_economizada'),
            'valor_economizado' => Impacto::sum('valor_economizado'),
            'nota_media' => round((float) Avaliacao::avg('nota'), 2),
        ];

        $porStatus = Transacao::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $porMaterial = Residuo::select('tipo_material', DB::raw('sum(quantidade) as total'))
            ->groupBy('tipo_material')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        return view('painel.dashboard_sustentavel.index', compact('indicadores', 'porStatus', 'porMaterial'));
    }
}
