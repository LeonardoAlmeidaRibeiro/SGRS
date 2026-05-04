<?php

namespace App\Services;

use App\Models\Residuo;
use App\Models\Transacao;

class ValidacaoLegalService
{
    public function validarResiduoParaMarketplace(Residuo $residuo): ?string
    {
        if (!$residuo->documentacao_validada) {
            return 'A documentacao legal do residuo ainda nao foi validada.';
        }

        if (!$residuo->mtr_url && !$residuo->licenca_ambiental_url) {
            return 'Anexe o MTR ou a licenca ambiental antes de listar o residuo.';
        }

        if ($residuo->classificacao && $residuo->classificacao->exige_mtr && !$residuo->mtr_url) {
            return 'Esta classificacao exige MTR.';
        }

        return null;
    }

    public function validarTransacaoParaStatus(Transacao $transacao, string $status): ?string
    {
        if (!in_array($status, ['aprovado', 'concluido'], true)) {
            return null;
        }

        $transacao->loadMissing(['residuo.classificacao', 'documentos']);
        $classificacao = optional($transacao->residuo)->classificacao;

        if (!$transacao->documentos->where('status_validacao', 'valido')->count()) {
            return 'Para aprovar ou concluir, a transacao precisa ter pelo menos um documento valido.';
        }

        if ($classificacao && $classificacao->exige_mtr && !$this->temDocumentoValido($transacao, 'MTR')) {
            return 'A classificacao do residuo exige MTR valido.';
        }

        if ($classificacao && $classificacao->exige_cadri && !$this->temDocumentoValido($transacao, 'CADRI')) {
            return 'A classificacao do residuo exige CADRI valido.';
        }

        if ($status === 'concluido' && !$transacao->data_recebimento) {
            return 'Informe a data de recebimento antes de concluir a transacao.';
        }

        return null;
    }

    public function documentoPodeSerValido(array $dados): ?string
    {
        if (($dados['status_validacao'] ?? null) !== 'valido') {
            return null;
        }

        if (empty($dados['arquivo_url'])) {
            return 'Documento valido precisa ter arquivo anexado ou URL informada.';
        }

        if (!empty($dados['data_validade']) && strtotime($dados['data_validade']) < strtotime(date('Y-m-d'))) {
            return 'Documento vencido nao pode ser marcado como valido.';
        }

        return null;
    }

    private function temDocumentoValido(Transacao $transacao, string $tipo): bool
    {
        return $transacao->documentos
            ->where('tipo_documento', $tipo)
            ->where('status_validacao', 'valido')
            ->count() > 0;
    }
}
