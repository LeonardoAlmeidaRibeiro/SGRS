<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('classificacoes_residuo', function (Blueprint $table) {
            $table->enum('classe_nbr10004', ['perigoso', 'nao_perigoso'])->default('nao_perigoso')->after('codigo');
            $table->string('codigo_cer')->nullable()->after('classe_nbr10004');
        });
    }

    public function down(): void
    {
        Schema::table('classificacoes_residuo', function (Blueprint $table) {
            $table->dropColumn(['classe_nbr10004', 'codigo_cer']);
        });
    }
};
