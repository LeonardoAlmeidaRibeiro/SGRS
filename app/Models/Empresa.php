<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'nome',
        'email',
        'tipo_industria',
        'cnpj',
        'telefone',
        'cep',
        'endereco',
        'numero',
        'cidade',
        'estado',
        'latitude',
        'longitude',
    ];

    /**
     * Relacionamento: uma empresa tem muitos usuários
     */
    public function usuarios()
    {
        return $this->hasMany(User::class);
    }

    public function interesses()
    {
        return $this->hasMany(Interesse::class);
    }

    public function residuos()
    {
        return $this->hasMany(Residuo::class);
    }
}
