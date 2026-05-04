<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    const UPDATED_AT = null;

    protected $table = 'avaliacoes';

    protected $fillable = [
        'transacao_id',
        'empresa_avaliadora_id',
        'empresa_avaliada_id',
        'nota',
        'comentario',
    ];

    public function transacao()
    {
        return $this->belongsTo(Transacao::class);
    }

    public function empresaAvaliadora()
    {
        return $this->belongsTo(Empresa::class, 'empresa_avaliadora_id');
    }

    public function empresaAvaliada()
    {
        return $this->belongsTo(Empresa::class, 'empresa_avaliada_id');
    }
}
