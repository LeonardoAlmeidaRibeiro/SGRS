<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoTransacao extends Model
{
    const UPDATED_AT = null;

    protected $table = 'documentos_transacao';

    protected $fillable = [
        'transacao_id',
        'tipo_documento',
        'numero_documento',
        'arquivo_url',
        'data_emissao',
        'data_validade',
        'status_validacao',
    ];

    protected $casts = [
        'data_emissao' => 'date',
        'data_validade' => 'date',
    ];

    public function transacao()
    {
        return $this->belongsTo(Transacao::class);
    }
}
