<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('residuo_id')->constrained('residuos')->cascadeOnDelete();
            $table->foreignId('empresa_origem_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('empresa_destino_id')->constrained('empresas')->cascadeOnDelete();
            $table->enum('status', ['pendente', 'aprovado', 'concluido', 'cancelado'])->default('pendente');
            $table->date('data_transacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transacoes');
    }
};
