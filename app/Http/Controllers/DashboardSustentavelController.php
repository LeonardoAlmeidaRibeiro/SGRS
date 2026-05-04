<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Impacto;
use App\Models\Residuo;
use App\Models\Transacao;
use App\Support\EmpresaScope;
use Illuminate\Support\Facades\DB;

class DashboardSustentavelController extends Controller
{
    use EmpresaScope;

    public function index()
    {
        $empresaId = $this->empresaLogadaId();
        $transacoesEmpresa = $this->escopoTransacaoEmpresa(Transacao::query());

        $indicadores = [
            'residuos_disponiveis' => Residuo::where('status', 'disponivel')
                ->when($empresaId, function ($q) use ($empresaId) {
                    $q->where('empresa_id', $empresaId);
                })
                ->count(),
            'transacoes_concluidas' => (clone $transacoesEmpresa)->where('status', 'concluido')->count(),
            'quantidade_reaproveitada' => $this->escopoTransacaoEmpresa(Transacao::where('transacoes.status', 'concluido'))
                ->join('residuos', 'residuos.id', '=', 'transacoes.residuo_id')
                ->sum('residuos.quantidade'),
            'co2_economizado' => Impacto::whereHas('transacao', function ($q) { $this->escopoTransacaoEmpresa($q); })->sum('co2_economizado'),
            'agua_economizada' => Impacto::whereHas('transacao', function ($q) { $this->escopoTransacaoEmpresa($q); })->sum('agua_economizada'),
            'energia_economizada' => Impacto::whereHas('transacao', function ($q) { $this->escopoTransacaoEmpresa($q); })->sum('energia_economizada'),
            'valor_economizado' => Impacto::whereHas('transacao', function ($q) { $this->escopoTransacaoEmpresa($q); })->sum('valor_economizado'),
            'nota_media' => round((float) Avaliacao::when($empresaId, function ($q) use ($empresaId) {
                $q->where('empresa_avaliada_id', $empresaId);
            })->avg('nota'), 2),
        ];

        $porStatus = $this->escopoTransacaoEmpresa(Transacao::select('status', DB::raw('count(*) as total')))
            ->groupBy('status')
            ->pluck('total', 'status');

        $porMaterial = Residuo::select('tipo_material', DB::raw('sum(quantidade) as total'))
            ->when($empresaId, function ($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })
            ->groupBy('tipo_material')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        return view('painel.dashboard_sustentavel.index', compact('indicadores', 'porStatus', 'porMaterial'));
    }
}
