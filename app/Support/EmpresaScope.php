<?php

namespace App\Support;

use Illuminate\Support\Facades\Auth;

trait EmpresaScope
{
    protected function empresaLogadaId(): ?int
    {
        return Auth::check() ? Auth::user()->empresa_id : null;
    }

    protected function abortarSeNaoForEmpresa(?int $empresaId): void
    {
        $empresaLogadaId = $this->empresaLogadaId();

        if ($empresaLogadaId && (int) $empresaId !== (int) $empresaLogadaId) {
            abort(403, 'Registro nao pertence a empresa logada.');
        }
    }

    protected function escopoTransacaoEmpresa($query)
    {
        $empresaId = $this->empresaLogadaId();

        if (!$empresaId) {
            return $query;
        }

        return $query->where(function ($q) use ($empresaId) {
            $q->where('empresa_origem_id', $empresaId)
                ->orWhere('empresa_destino_id', $empresaId)
                ->orWhere('empresa_transportadora_id', $empresaId);
        });
    }
}
