<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Impacto extends Model
{
    const UPDATED_AT = null;

    protected $table = 'impactos';

    protected $fillable = [
        'transacao_id',
        'co2_economizado',
        'agua_economizada',
        'energia_economizada',
        'valor_economizado',
    ];

    protected $casts = [
        'co2_economizado' => 'decimal:3',
        'agua_economizada' => 'decimal:3',
        'energia_economizada' => 'decimal:3',
        'valor_economizado' => 'decimal:2',
    ];

    public function transacao()
    {
        return $this->belongsTo(Transacao::class);
    }
}
