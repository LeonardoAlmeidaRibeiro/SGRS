<?php

namespace App\Services;

use App\Models\Transacao;

class CalculoCarbonoService
{
    private array $fatores = [
        'plastico' => ['co2' => 1.7, 'agua' => 18, 'energia' => 2.4, 'valor' => 0.9],
        'papel' => ['co2' => 1.2, 'agua' => 45, 'energia' => 1.8, 'valor' => 0.55],
        'papelao' => ['co2' => 1.2, 'agua' => 45, 'energia' => 1.8, 'valor' => 0.55],
        'metal' => ['co2' => 2.8, 'agua' => 30, 'energia' => 5.4, 'valor' => 1.8],
        'sucata' => ['co2' => 2.8, 'agua' => 30, 'energia' => 5.4, 'valor' => 1.8],
        'vidro' => ['co2' => 0.9, 'agua' => 12, 'energia' => 1.4, 'valor' => 0.35],
        'organico' => ['co2' => 0.6, 'agua' => 8, 'energia' => 0.7, 'valor' => 0.25],
        'madeira' => ['co2' => 1.1, 'agua' => 10, 'energia' => 1.2, 'valor' => 0.4],
    ];

    public function calcularPorTransacao(Transacao $transacao): array
    {
        $transacao->loadMissing('residuo.unidade');

        $residuo = $transacao->residuo;
        $quantidadeKg = (float) ($residuo->quantidade_em_kg ?? $residuo->quantidade ?? 0);

        return $this->calcular($residuo->tipo_material ?? '', $quantidadeKg);
    }

    public function calcular(string $tipoMaterial, float $quantidadeKg): array
    {
        $fator = $this->fatorParaMaterial($tipoMaterial);

        return [
            'co2_economizado' => round($quantidadeKg * $fator['co2'], 3),
            'agua_economizada' => round($quantidadeKg * $fator['agua'], 3),
            'energia_economizada' => round($quantidadeKg * $fator['energia'], 3),
            'valor_economizado' => round($quantidadeKg * $fator['valor'], 2),
        ];
    }

    public function fatorParaMaterial(string $tipoMaterial): array
    {
        $tipo = $this->normalizar($tipoMaterial);

        foreach ($this->fatores as $palavraChave => $fator) {
            if (strpos($tipo, $palavraChave) !== false) {
                return $fator;
            }
        }

        return ['co2' => 1.6, 'agua' => 22, 'energia' => 2.1, 'valor' => 0.75];
    }

    private function normalizar(string $valor): string
    {
        $valor = mb_strtolower($valor);
        $mapa = [
            'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a',
            'é' => 'e', 'ê' => 'e',
            'í' => 'i',
            'ó' => 'o', 'õ' => 'o', 'ô' => 'o',
            'ú' => 'u',
            'ç' => 'c',
        ];

        return strtr($valor, $mapa);
    }
}
