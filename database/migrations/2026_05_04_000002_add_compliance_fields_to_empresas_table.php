<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->boolean('possui_licenca_ambiental')->default(false)->after('longitude');
            $table->boolean('licenca_residuos_perigosos')->default(false)->after('possui_licenca_ambiental');
            $table->string('numero_licenca_ambiental')->nullable()->after('licenca_residuos_perigosos');
            $table->date('validade_licenca_ambiental')->nullable()->after('numero_licenca_ambiental');
            $table->string('licenca_ambiental_url')->nullable()->after('validade_licenca_ambiental');
            $table->decimal('reputacao_media', 3, 2)->default(0)->after('licenca_ambiental_url');
            $table->decimal('taxa_conformidade', 5, 2)->default(100)->after('reputacao_media');
            $table->boolean('restrita_por_reputacao')->default(false)->after('taxa_conformidade');
        });
    }

    public function down(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropColumn([
                'possui_licenca_ambiental',
                'licenca_residuos_perigosos',
                'numero_licenca_ambiental',
                'validade_licenca_ambiental',
                'licenca_ambiental_url',
                'reputacao_media',
                'taxa_conformidade',
                'restrita_por_reputacao',
            ]);
        });
    }
};
