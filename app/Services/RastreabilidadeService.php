<?php

namespace App\Services;

use App\Models\RastreabilidadeLog;
use App\Models\Transacao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RastreabilidadeService
{
    public function prepararTransacao(array $dados): array
    {
        $codigo = $dados['codigo_rastreio'] ?? $this->gerarCodigo();
        $dados['codigo_rastreio'] = $codigo;
        $dados['hash_rastreio'] = $dados['hash_rastreio'] ?? $this->gerarHash($codigo, $dados);

        return $dados;
    }

    public function registrar(Transacao $transacao, string $acao, string $descricao, ?string $documentoUrl = null): RastreabilidadeLog
    {
        $empresaId = optional(Auth::user())->empresa_id ?: $transacao->empresa_origem_id;
        $userId = optional(Auth::user())->id;
        $base = implode('|', [
            $transacao->codigo_rastreio,
            $acao,
            $empresaId,
            $userId,
            now()->toDateTimeString(),
            Str::random(12),
        ]);

        return RastreabilidadeLog::create([
            'transacao_id' => $transacao->id,
            'empresa_id' => $empresaId,
            'user_id' => $userId,
            'acao' => $acao,
            'descricao' => $descricao,
            'documento_url' => $documentoUrl,
            'hash_evento' => hash('sha256', $base),
        ]);
    }

    private function gerarCodigo(): string
    {
        do {
            $codigo = 'TRC-' . now()->format('Ymd') . '-' . strtoupper(Str::random(8));
        } while (Transacao::where('codigo_rastreio', $codigo)->exists());

        return $codigo;
    }

    private function gerarHash(string $codigo, array $dados): string
    {
        return hash('sha256', $codigo . '|' . json_encode($dados) . '|' . microtime(true));
    }
}
