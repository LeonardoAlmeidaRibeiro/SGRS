<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentos_transacao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transacao_id')->constrained('transacoes')->cascadeOnDelete();
            $table->enum('tipo_documento', ['MTR', 'CADRI', 'nota_fiscal', 'contrato']);
            $table->string('numero_documento')->nullable();
            $table->string('arquivo_url')->nullable();
            $table->date('data_emissao')->nullable();
            $table->date('data_validade')->nullable();
            $table->enum('status_validacao', ['pendente', 'valido', 'vencido', 'rejeitado'])->default('pendente');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentos_transacao');
    }
};
