<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY perfil VARCHAR(30) NOT NULL DEFAULT 'operador'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY perfil ENUM('admin', 'operador') NOT NULL DEFAULT 'operador'");
    }
};
