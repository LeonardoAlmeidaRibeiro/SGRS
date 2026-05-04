<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    protected $table = 'transacoes';

    protected $fillable = [
        'residuo_id',
        'empresa_origem_id',
        'empresa_destino_id',
        'empresa_transportadora_id',
        'status',
        'data_transacao',
        'data_recebimento',
        'codigo_rastreio',
        'hash_rastreio',
    ];

    protected $casts = [
        'data_transacao' => 'date',
        'data_recebimento' => 'datetime',
    ];

    public function residuo()
    {
        return $this->belongsTo(Residuo::class);
    }

    public function empresaOrigem()
    {
        return $this->belongsTo(Empresa::class, 'empresa_origem_id');
    }

    public function empresaDestino()
    {
        return $this->belongsTo(Empresa::class, 'empresa_destino_id');
    }

    public function empresaTransportadora()
    {
        return $this->belongsTo(Empresa::class, 'empresa_transportadora_id');
    }

    public function documentos()
    {
        return $this->hasMany(DocumentoTransacao::class, 'transacao_id');
    }

    public function impacto()
    {
        return $this->hasOne(Impacto::class, 'transacao_id');
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'transacao_id');
    }

    public function logsRastreabilidade()
    {
        return $this->hasMany(RastreabilidadeLog::class, 'transacao_id');
    }
}
