<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UnidadesMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        $unidades = [
            // Unidades de massa (fator = 1 para kg)
            [
                'nome' => 'Quilograma',
                'fator_conversao_para_kg' => 1.0000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Grama',
                'fator_conversao_para_kg' => 0.0010,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Tonelada',
                'fator_conversao_para_kg' => 1000.0000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Libra',
                'fator_conversao_para_kg' => 0.4536,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Onça',
                'fator_conversao_para_kg' => 0.02835,
                'created_at' => $now,
                'updated_at' => $now
            ],
            
            // Unidades de volume (convertendo para kg baseado em água/densidade padrão)
            [
                'nome' => 'Litro',
                'fator_conversao_para_kg' => 1.0000, // 1L de água = 1kg
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Mililitro',
                'fator_conversao_para_kg' => 0.0010, // 1mL de água = 0.001kg
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Metro Cúbico',
                'fator_conversao_para_kg' => 1000.0000, // 1m³ de água = 1000kg
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Galão (Americano)',
                'fator_conversao_para_kg' => 3.7854, // 1 galão americano de água = 3.785kg
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Galão (Britânico)',
                'fator_conversao_para_kg' => 4.5461, // 1 galão britânico de água = 4.546kg
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Barril (Petróleo)',
                'fator_conversao_para_kg' => 158.9873, // 1 barril = aproximadamente 159kg
                'created_at' => $now,
                'updated_at' => $now
            ],
            
            // Unidades de volume específicas para resíduos
            [
                'nome' => 'Caçamba (5m³)',
                'fator_conversao_para_kg' => 5000.0000, // 5m³ = 5000kg aproximado
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Caçamba (7m³)',
                'fator_conversao_para_kg' => 7000.0000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Caçamba (10m³)',
                'fator_conversao_para_kg' => 10000.0000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Container (20 pés)',
                'fator_conversao_para_kg' => 21800.0000, // Capacidade média
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Container (40 pés)',
                'fator_conversao_para_kg' => 26600.0000, // Capacidade média
                'created_at' => $now,
                'updated_at' => $now
            ],
            
            // Unidades de quantidade (itens)
            [
                'nome' => 'Unidade',
                'fator_conversao_para_kg' => 0.5000, // Média por unidade (valor aproximado)
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Cento',
                'fator_conversao_para_kg' => 50.0000, // 100 unidades * 0.5kg
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Milheiro',
                'fator_conversao_para_kg' => 500.0000, // 1000 unidades * 0.5kg
                'created_at' => $now,
                'updated_at' => $now
            ],
            
            // Unidades de pressão/volume para gases
            [
                'nome' => 'Metro Cúbico (Gás)',
                'fator_conversao_para_kg' => 1.2500, // 1m³ de gás natural ≈ 1.25kg
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Cilindro (13kg)',
                'fator_conversao_para_kg' => 13.0000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Cilindro (45kg)',
                'fator_conversao_para_kg' => 45.0000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            
            // Unidades específicas para recicláveis
            [
                'nome' => 'Fardo (Papelão)',
                'fator_conversao_para_kg' => 250.0000, // Fardo médio de papelão
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Fardo (Plástico)',
                'fator_conversao_para_kg' => 50.0000, // Fardo médio de plástico
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Fardo (Alumínio)',
                'fator_conversao_para_kg' => 30.0000, // Fardo médio de alumínio
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Palete',
                'fator_conversao_para_kg' => 500.0000, // Palete médio
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Big Bag',
                'fator_conversao_para_kg' => 1000.0000, // Big bag padrão
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Tambor (200L)',
                'fator_conversao_para_kg' => 200.0000, // Tambor de 200L
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Bombona (50L)',
                'fator_conversao_para_kg' => 50.0000, // Bombona de 50L
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Saco (100L)',
                'fator_conversao_para_kg' => 25.0000, // Saco de 100L
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];
        
        DB::table('unidades_medida')->insert($unidades);
    }
}