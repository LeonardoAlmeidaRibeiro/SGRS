<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('impactos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transacao_id')->constrained('transacoes')->cascadeOnDelete();
            $table->decimal('co2_economizado', 12, 3)->default(0);
            $table->decimal('agua_economizada', 12, 3)->default(0);
            $table->decimal('energia_economizada', 12, 3)->default(0);
            $table->decimal('valor_economizado', 12, 2)->default(0);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('impactos');
    }
};
