<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();

            $table->string('nome');
            $table->string('email')->unique();

            $table->string('tipo_industria');

            $table->string('cnpj')->unique();
            $table->string('telefone');

            $table->string('cep');
            $table->string('endereco');
            $table->string('numero');

            $table->string('cidade');
            $table->string('estado');

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};