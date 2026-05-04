<?php

namespace App\Services;

use App\Models\Empresa;

class ReputacaoEmpresaService
{
    public function recalcular(Empresa $empresa): void
    {
        $avaliacoes = $empresa->avaliacoesRecebidas();
        $media = (float) $avaliacoes->avg('nota');
        $totalConformidade = (clone $avaliacoes)->whereNotNull('residuo_conforme')->count();
        $conformes = (clone $avaliacoes)->where('residuo_conforme', true)->count();
        $taxaConformidade = $totalConformidade > 0 ? round(($conformes / $totalConformidade) * 100, 2) : 100;

        $empresa->update([
            'reputacao_media' => round($media, 2),
            'taxa_conformidade' => $taxaConformidade,
            'restrita_por_reputacao' => $media > 0 && $media < 3,
        ]);
    }
}
