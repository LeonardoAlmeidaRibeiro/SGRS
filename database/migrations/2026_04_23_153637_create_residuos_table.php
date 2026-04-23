<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('residuos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();

            $table->foreignId('classificacao_id')
                ->constrained('classificacoes_residuo')
                ->cascadeOnDelete();

            $table->string('tipo_material');
            $table->text('descricao')->nullable();

            $table->decimal('quantidade', 12, 3);

            $table->foreignId('unidade_id')
                ->constrained('unidades_medida');

            $table->enum('status', ['disponivel', 'reservado', 'finalizado'])
                ->default('disponivel');

            $table->string('endereco');
            $table->string('cidade');
            $table->string('estado');

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residuos');
    }
};
