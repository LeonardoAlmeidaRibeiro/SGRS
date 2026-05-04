<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RastreabilidadeLog extends Model
{
    protected $table = 'rastreabilidade_logs';

    protected $fillable = [
        'transacao_id',
        'empresa_id',
        'user_id',
        'acao',
        'descricao',
        'documento_url',
        'hash_evento',
    ];

    public function transacao()
    {
        return $this->belongsTo(Transacao::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
