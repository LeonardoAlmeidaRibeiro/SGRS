<?php

namespace App\Services;

use App\Models\Transacao;
use Symfony\Component\Process\Process;

class ImpactoCalculatorService
{
    private CalculoCarbonoService $calculoCarbonoService;

    public function __construct(CalculoCarbonoService $calculoCarbonoService)
    {
        $this->calculoCarbonoService = $calculoCarbonoService;
    }

    public function calcular(Transacao $transacao): array
    {
        $transacao->loadMissing(['residuo.unidade']);
        $residuo = $transacao->residuo;
        $quantidadeKg = (float) ($residuo->quantidade_em_kg ?? $residuo->quantidade ?? 0);
        $payload = [
            'tipo_material' => $residuo->tipo_material,
            'quantidade_kg' => $quantidadeKg,
        ];

        try {
            $process = new Process(['python', base_path('python_services/impact_calculator.py'), json_encode($payload)]);
            $process->setTimeout(10);
            $process->run();

            if ($process->isSuccessful()) {
                $resultado = json_decode($process->getOutput(), true);

                if (is_array($resultado)) {
                    return $resultado;
                }
            }
        } catch (\Throwable $e) {
            // Fallback abaixo mantém o Laravel funcionando quando o Python não estiver configurado.
        }

        return $this->calculoCarbonoService->calcular($payload['tipo_material'], $quantidadeKg);
    }
}
