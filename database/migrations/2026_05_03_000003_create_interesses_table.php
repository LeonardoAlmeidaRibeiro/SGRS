<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->string('tipo_material');
            $table->foreignId('classificacao_id')->constrained('classificacoes_residuo')->cascadeOnDelete();
            $table->decimal('quantidade_minima', 12, 3)->nullable();
            $table->decimal('quantidade_maxima', 12, 3)->nullable();
            $table->decimal('raio_km', 8, 2)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interesses');
    }
};
