<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transacoes', function (Blueprint $table) {
            $table->foreignId('empresa_transportadora_id')->nullable()->after('empresa_destino_id')->constrained('empresas')->nullOnDelete();
            $table->timestamp('data_recebimento')->nullable()->after('data_transacao');
            $table->string('codigo_rastreio')->nullable()->unique()->after('data_recebimento');
            $table->string('hash_rastreio', 64)->nullable()->after('codigo_rastreio');
        });
    }

    public function down(): void
    {
        Schema::table('transacoes', function (Blueprint $table) {
            $table->dropForeign(['empresa_transportadora_id']);
            $table->dropColumn(['empresa_transportadora_id', 'data_recebimento', 'codigo_rastreio', 'hash_rastreio']);
        });
    }
};
