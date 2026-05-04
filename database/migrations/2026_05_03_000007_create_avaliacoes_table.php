<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transacao_id')->constrained('transacoes')->cascadeOnDelete();
            $table->foreignId('empresa_avaliadora_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('empresa_avaliada_id')->constrained('empresas')->cascadeOnDelete();
            $table->unsignedTinyInteger('nota');
            $table->text('comentario')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
