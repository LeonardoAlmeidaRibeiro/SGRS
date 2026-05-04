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
        'classe_nbr10004',
        'codigo_cer',
        'exige_mtr',
        'exige_cadri',
    ];

    protected $casts = [
        'exige_mtr' => 'boolean',
        'exige_cadri' => 'boolean',
    ];

    public function getEhPerigosoAttribute()
    {
        return $this->classe_nbr10004 === 'perigoso';
    }

    public function residuos()
    {
        return $this->hasMany(Residuo::class, 'classificacao_id');
    }
}
