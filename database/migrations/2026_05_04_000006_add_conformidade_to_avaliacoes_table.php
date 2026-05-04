<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConformidadeToAvaliacoesTable extends Migration
{
    public function up()
    {
        Schema::table('avaliacoes', function (Blueprint $table) {
            $table->boolean('residuo_conforme')->nullable()->after('nota');
        });
    }

    public function down()
    {
        Schema::table('avaliacoes', function (Blueprint $table) {
            $table->dropColumn('residuo_conforme');
        });
    }
}
