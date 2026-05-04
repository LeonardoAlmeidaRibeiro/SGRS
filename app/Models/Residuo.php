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
    ];

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
