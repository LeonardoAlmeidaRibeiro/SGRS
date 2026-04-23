<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadeMedida extends Model
{
    protected $table = 'unidades_medida';

    protected $fillable = [
        'nome',
        'fator_conversao_para_kg',
    ];

    public function residuos()
    {
        return $this->hasMany(Residuo::class, 'unidade_id');
    }
}
