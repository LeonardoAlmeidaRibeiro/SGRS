<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $empresa = Empresa::create([
            'nome' => 'Empresa Teste',
            'email' => 'empresa@teste.com',
            'tipo_industria' => 'TI',
            'cnpj' => '00.000.000/0001-00',
            'telefone' => '(11) 99999-9999',
            'cep' => '00000-000',
            'endereco' => 'Rua Teste',
            'numero' => '123',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
        ]);

        User::create([
            'empresa_id' => $empresa->id,
            'name' => 'Admin',
            'email' => 'admin@teste.com',
            'password' => Hash::make('123456'),
            'perfil' => 'admin',
        ]);;

        $this->call(EstadosTableSeeder::class);
        $this->call(CidadesTableSeeder::class);
    }
}
