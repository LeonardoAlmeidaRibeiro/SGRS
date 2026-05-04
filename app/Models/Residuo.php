<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Residuo extends Model
{
    protected $table = 'residuos';

    protected $fillable = [
        'empresa_id',
        'classificacao_id',
        'tipo_material',
        'descricao',
        'imagem',
        'mtr_url',
        'licenca_ambiental_url',
        'checklist_origem_preenchido',
        'checklist_classificacao_confirmada',
        'checklist_acondicionamento_confirmado',
        'checklist_transporte_confirmado',
        'assinatura_digital',
        'checklist_assinado_em',
        'documentacao_validada',
        'observacao_validacao',
        'quantidade',
        'unidade_id',
        'status',
        'endereco',
        'cidade',
        'estado',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'quantidade' => 'decimal:3',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'checklist_origem_preenchido' => 'boolean',
        'checklist_classificacao_confirmada' => 'boolean',
        'checklist_acondicionamento_confirmado' => 'boolean',
        'checklist_transporte_confirmado' => 'boolean',
        'checklist_assinado_em' => 'datetime',
        'documentacao_validada' => 'boolean',
    ];

    public function getPodeSerListadoAttribute(): bool
    {
        return $this->status === 'disponivel'
            && $this->documentacao_validada
            && ($this->mtr_url || $this->licenca_ambiental_url);
    }

    /*
     * RELACIONAMENTOS
     */

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function classificacao()
    {
        return $this->belongsTo(ClassificacaoResiduo::class, 'classificacao_id');
    }

    public function unidade()
    {
        return $this->belongsTo(UnidadeMedida::class, 'unidade_id');
    }

    /*
     * HELPERS
     */

    public function getQuantidadeEmKgAttribute()
    {
        if (!$this->unidade) {
            return null;
        }

        return $this->quantidade * $this->unidade->fator_conversao_para_kg;
    }
}
