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
        Schema::create('classificacoes_residuo', function (Blueprint $table) {
    $table->id();

    $table->string('nome'); // Classe I - Perigoso
    $table->string('codigo'); // NBR10004/I

    $table->boolean('exige_mtr')->default(false);
    $table->boolean('exige_cadri')->default(false);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classificacoes_residuo');
    }
};
