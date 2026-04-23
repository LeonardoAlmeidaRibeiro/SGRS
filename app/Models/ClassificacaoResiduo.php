<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificacaoResiduo extends Model
{
    protected $table = 'classificacoes_residuo';

    protected $fillable = [
        'nome',
        'codigo',
        'exige_mtr',
        'exige_cadri',
    ];

    public function residuos()
    {
        return $this->hasMany(Residuo::class, 'classificacao_id');
    }
}