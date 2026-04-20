<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'cad_bas_estados';

    protected $fillable = ['nome','sigla'];
    
    public function getNomeAttribute($value)
    {
       return mb_strtoupper($value);
    }
    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = mb_strtoupper($value);
    }
}
