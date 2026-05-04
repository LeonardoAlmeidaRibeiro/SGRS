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

    public function run(): void
    {
        $empresa = Empresa::updateOrCreate(
            ['cnpj' => '00.000.000/0001-00'],
            [
                'nome' => 'Empresa Teste',
                'email' => 'empresa@teste.com',
                'tipo_industria' => 'TI',
                'telefone' => '(11) 99999-9999',
                'cep' => '00000-000',
                'endereco' => 'Rua Teste',
                'numero' => '123',
                'cidade' => 'Sao Paulo',
                'estado' => 'SP',
                'latitude' => -23.5505200,
                'longitude' => -46.6333080,
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@teste.com'],
            [
                'empresa_id' => $empresa->id,
                'name' => 'Admin',
                'password' => Hash::make('123456'),
                'perfil' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'operador@teste.com'],
            [
                'empresa_id' => $empresa->id,
                'name' => 'Operador Teste',
                'password' => Hash::make('123456'),
                'perfil' => 'operador',
            ]
        );

        $this->call(EstadosTableSeeder::class);
        $this->call(CidadesTableSeeder::class);
        $this->call(ClassificacoesResiduoSeeder::class);
        $this->call(UnidadesMedidaSeeder::class);
        $this->call(ResiduosSeeder::class);
        $this->call(DemoSgrsSeeder::class);
    }
}
