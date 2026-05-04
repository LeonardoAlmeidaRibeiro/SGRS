<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('residuos', function (Blueprint $table) {
            $table->string('mtr_url')->nullable()->after('imagem');
            $table->string('licenca_ambiental_url')->nullable()->after('mtr_url');
            $table->boolean('checklist_origem_preenchido')->default(false)->after('licenca_ambiental_url');
            $table->boolean('checklist_quantidade_confirmada')->default(false)->after('checklist_origem_preenchido');
            $table->boolean('checklist_acondicionamento_confirmado')->default(false)->after('checklist_quantidade_confirmada');
            $table->boolean('checklist_documentos_conferidos')->default(false)->after('checklist_acondicionamento_confirmado');
            $table->string('assinatura_digital')->nullable()->after('checklist_documentos_conferidos');
            $table->timestamp('checklist_assinado_em')->nullable()->after('assinatura_digital');
            $table->boolean('documentacao_validada')->default(false)->after('checklist_assinado_em');
            $table->text('observacao_validacao')->nullable()->after('documentacao_validada');
        });
    }

    public function down(): void
    {
        Schema::table('residuos', function (Blueprint $table) {
            $table->dropColumn([
                'mtr_url',
                'licenca_ambiental_url',
                'checklist_origem_preenchido',
                'checklist_quantidade_confirmada',
                'checklist_acondicionamento_confirmado',
                'checklist_documentos_conferidos',
                'assinatura_digital',
                'checklist_assinado_em',
                'documentacao_validada',
                'observacao_validacao',
            ]);
        });
    }
};
