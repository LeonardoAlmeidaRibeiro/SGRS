<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Campos permitidos para mass assignment
     */
    protected $fillable = [
        'empresa_id',
        'name',
        'email',
        'telefone',
        'cpf',
        'data_nascimento',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'password',
        'perfil',
    ];

    /**
     * Campos ocultos
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts automáticos
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'data_nascimento' => 'date',
            'password' => 'hashed',
        ];
    }

    /**
     * Relacionamento: usuário pertence a uma empresa
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function temPerfil($perfis): bool
    {
        $perfis = is_array($perfis) ? $perfis : func_get_args();

        return in_array($this->perfil, $perfis, true);
    }
}
