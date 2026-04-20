<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use HasFactory;

    protected $table = 'cad_bas_cidades';

    protected $fillable = ['estado_id','nome','cod_municipio'];
    
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
    public function getNomeAttribute($value)
    {
       return mb_strtoupper($value);
    }
    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = mb_strtoupper($value);
    }
}