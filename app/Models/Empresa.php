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
        'possui_licenca_ambiental',
        'licenca_residuos_perigosos',
        'numero_licenca_ambiental',
        'validade_licenca_ambiental',
        'licenca_ambiental_url',
        'reputacao_media',
        'taxa_conformidade',
        'restrita_por_reputacao',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'possui_licenca_ambiental' => 'boolean',
        'licenca_residuos_perigosos' => 'boolean',
        'validade_licenca_ambiental' => 'date',
        'reputacao_media' => 'decimal:2',
        'taxa_conformidade' => 'decimal:2',
        'restrita_por_reputacao' => 'boolean',
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

    public function avaliacoesRecebidas()
    {
        return $this->hasMany(Avaliacao::class, 'empresa_avaliada_id');
    }

    public function podeReceberResiduoPerigoso(): bool
    {
        return $this->possui_licenca_ambiental
            && $this->licenca_residuos_perigosos
            && (!$this->validade_licenca_ambiental || $this->validade_licenca_ambiental->isFuture());
    }
}
