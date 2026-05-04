<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interesse extends Model
{
    const UPDATED_AT = null;

    protected $table = 'interesses';

    protected $fillable = [
        'empresa_id',
        'tipo_material',
        'classificacao_id',
        'quantidade_minima',
        'quantidade_maxima',
        'raio_km',
    ];

    protected $casts = [
        'quantidade_minima' => 'decimal:3',
        'quantidade_maxima' => 'decimal:3',
        'raio_km' => 'decimal:2',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function classificacao()
    {
        return $this->belongsTo(ClassificacaoResiduo::class, 'classificacao_id');
    }
}
