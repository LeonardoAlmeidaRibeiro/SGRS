<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ResiduosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        // Primeiro, vamos buscar alguns IDs existentes
        $empresas = DB::table('empresas')->pluck('id')->toArray();
        $classificacoes = DB::table('classificacoes_residuo')->pluck('id')->toArray();
        $unidades = DB::table('unidades_medida')->pluck('id')->toArray();
        
        // Se não houver dados, usar IDs padrão (1, 2, 3...)
        if (empty($empresas)) {
            $empresas = [1, 2, 3];
        }
        if (empty($classificacoes)) {
            $classificacoes = [1, 2, 3];
        }
        if (empty($unidades)) {
            $unidades = [1, 2, 3];
        }
        
        $residuos = [
            // Resíduos Industriais
            [
                'empresa_id' => $empresas[array_rand($empresas)],
                'classificacao_id' => $classificacoes[0] ?? 1,
                'tipo_material' => 'Plástico Industrial',
                'descricao' => 'Aparas de plástico industrial, alta qualidade para reciclagem',
                'quantidade' => 1250.500,
                'unidade_id' => $unidades[0] ?? 1,
                'status' => 'disponivel',
                'endereco' => 'Av. Industrial, 1000',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'latitude' => -23.5505200,
                'longitude' => -46.6333080,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'empresa_id' => $empresas[array_rand($empresas)],
                'classificacao_id' => $classificacoes[1] ?? 2,
                'tipo_material' => 'Resíduo Químico',
                'descricao' => 'Solventes industriais para tratamento',
                'quantidade' => 500.000,
                'unidade_id' => $unidades[1] ?? 2,
                'status' => 'disponivel',
                'endereco' => 'Rua das Indústrias, 500',
                'cidade' => 'São Bernardo do Campo',
                'estado' => 'SP',
                'latitude' => -23.6956300,
                'longitude' => -46.5634560,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'empresa_id' => $empresas[array_rand($empresas)],
                'classificacao_id' => $classificacoes[2] ?? 3,
                'tipo_material' => 'Resíduo Hospitalar',
                'descricao' => 'Resíduos infectantes do grupo A',
                'quantidade' => 75.200,
                'unidade_id' => $unidades[2] ?? 3,
                'status' => 'reservado',
                'endereco' => 'Hospital Central, 200',
                'cidade' => 'Rio de Janeiro',
                'estado' => 'RJ',
                'latitude' => -22.9068470,
                'longitude' => -43.1728960,
                'created_at' => $now,
                'updated_at' => $now
            ],
            
            // Resíduos de Construção
            [
                'empresa_id' => $empresas[array_rand($empresas)],
                'classificacao_id' => $classificacoes[3] ?? 4,
                'tipo_material' => 'Entulho',
                'descricao' => 'Entulho de construção civil - concreto e tijolos',
                'quantidade' => 3500.000,
                'unidade_id' => $unidades[0] ?? 1,
                'status' => 'disponivel',
                'endereco' => 'Av. das Construções, 1500',
                'cidade' => 'Belo Horizonte',
                'estado' => 'MG',
                'latitude' => -19.9166810,
                'longitude' => -43.9344930,
                'created_at' => $now,
                'updated_at' => $now
            ],
            
            // Resíduos Eletrônicos
            [
                'empresa_id' => $empresas[array_rand($empresas)],
                'classificacao_id' => $classificacoes[4] ?? 5,
                'tipo_material' => 'Eletrônicos',
                'descricao' => 'Placas-mãe e componentes eletrônicos para reciclagem',
                'quantidade' => 320.000,
                'unidade_id' => $unidades[1] ?? 2,
                'status' => 'disponivel',
                'endereco' => 'Rua Tecnologia, 100',
                'cidade' => 'Campinas',
                'estado' => 'SP',
                'latitude' => -22.9055560,
                'longitude' => -47.0608330,
                'created_at' => $now,
                'updated_at' => $now
            ],
            
            // Resíduos Orgânicos
            [
                'empresa_id' => $empresas[array_rand($empresas)],
                'classificacao_id' => $classificacoes[5] ?? 6,
                'tipo_material' => 'Resíduo Orgânico',
                'descricao' => 'Restos de alimentos para compostagem',
                'quantidade' => 850.750,
                'unidade_id' => $unidades[0] ?? 1,
                'status' => 'disponivel',
                'endereco' => 'Zona Rural, Km 15',
                'cidade' => 'Curitiba',
                'estado' => 'PR',
                'latitude' => -25.4289540,
                'longitude' => -49.2671370,
                'created_at' => $now,
                'updated_at' => $now
            ],
            
            // Resíduos de Óleo
            [
                'empresa_id' => $empresas[array_rand($empresas)],
                'classificacao_id' => $classificacoes[6] ?? 7,
                'tipo_material' => 'Óleo Lubrificante',
                'descricao' => 'Óleo usado para rerrefino',
                'quantidade' => 1500.000,
                'unidade_id' => $unidades[1] ?? 2,
                'status' => 'reservado',
                'endereco' => 'Av. dos Automóveis, 2000',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'latitude' => -23.5489000,
                'longitude' => -46.6388000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            
            // Papel e Papelão
            [
                'empresa_id' => $empresas[array_rand($empresas)],
                'classificacao_id' => $classificacoes[7] ?? 8,
                'tipo_material' => 'Papel e Papelão',
                'descricao' => 'Papelão ondulado e papel branco para reciclagem',
                'quantidade' => 2800.000,
                'unidade_id' => $unidades[0] ?? 1,
                'status' => 'finalizado',
                'endereco' => 'Rua da Reciclagem, 50',
                'cidade' => 'Porto Alegre',
                'estado' => 'RS',
                'latitude' => -30.0346470,
                'longitude' => -51.2176580,
                'created_at' => $now,
                'updated_at' => $now
            ],
            
            // Resíduos de Metais
            [
                'empresa_id' => $empresas[array_rand($empresas)],
                'classificacao_id' => $classificacoes[8] ?? 9,
                'tipo_material' => 'Sucata Metálica',
                'descricao' => 'Ferro, aço e alumínio para reciclagem',
                'quantidade' => 4200.000,
                'unidade_id' => $unidades[0] ?? 1,
                'status' => 'disponivel',
                'endereco' => 'Av. Metalúrgica, 800',
                'cidade' => 'Contagem',
                'estado' => 'MG',
                'latitude' => -19.9200000,
                'longitude' => -44.0600000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            
            // Resíduos de Vidro
            [
                'empresa_id' => $empresas[array_rand($empresas)],
                'classificacao_id' => $classificacoes[9] ?? 10,
                'tipo_material' => 'Vidro',
                'descricao' => 'Garrafas e cacos de vidro para reciclagem',
                'quantidade' => 450.000,
                'unidade_id' => $unidades[0] ?? 1,
                'status' => 'disponivel',
                'endereco' => 'Rua do Vidro, 300',
                'cidade' => 'São José dos Pinhais',
                'estado' => 'PR',
                'latitude' => -25.5350000,
                'longitude' => -49.2050000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            
            // Resíduos de Borracha
            [
                'empresa_id' => $empresas[array_rand($empresas)],
                'classificacao_id' => $classificacoes[10] ?? 11,
                'tipo_material' => 'Pneus Inservíveis',
                'descricao' => 'Pneus para trituração e reciclagem',
                'quantidade' => 180.000,
                'unidade_id' => $unidades[2] ?? 3,
                'status' => 'disponivel',
                'endereco' => 'Av. dos Pneus, 1500',
                'cidade' => 'Santo André',
                'estado' => 'SP',
                'latitude' => -23.6600000,
                'longitude' => -46.5300000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            
            // Resíduos Radioativos
            [
                'empresa_id' => $empresas[array_rand($empresas)],
                'classificacao_id' => $classificacoes[11] ?? 12,
                'tipo_material' => 'Resíduo Radioativo',
                'descricao' => 'Materiais com baixa radioatividade para descarte especial',
                'quantidade' => 2.500,
                'unidade_id' => $unidades[0] ?? 1,
                'status' => 'reservado',
                'endereco' => 'Área Restrita, Zona Industrial',
                'cidade' => 'Resende',
                'estado' => 'RJ',
                'latitude' => -22.4680000,
                'longitude' => -44.4460000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            
            // Resíduos Têxteis
            [
                'empresa_id' => $empresas[array_rand($empresas)],
                'classificacao_id' => $classificacoes[12] ?? 13,
                'tipo_material' => 'Resíduo Têxtil',
                'descricao' => 'Retalhos de tecido e roupas inutilizadas',
                'quantidade' => 680.000,
                'unidade_id' => $unidades[0] ?? 1,
                'status' => 'disponivel',
                'endereco' => 'Rua da Moda, 100',
                'cidade' => 'Joinville',
                'estado' => 'SC',
                'latitude' => -26.3040000,
                'longitude' => -48.8460000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            
            // Resíduos de Madeira
            [
                'empresa_id' => $empresas[array_rand($empresas)],
                'classificacao_id' => $classificacoes[13] ?? 14,
                'tipo_material' => 'Madeira',
                'descricao' => 'Paletes e sobras de madeira para reuso',
                'quantidade' => 2100.000,
                'unidade_id' => $unidades[0] ?? 1,
                'status' => 'disponivel',
                'endereco' => 'Av. da Madeira, 500',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'latitude' => -23.5505200,
                'longitude' => -46.6333080,
                'created_at' => $now,
                'updated_at' => $now
            ],
            
            // Resíduos de Gesso
            [
                'empresa_id' => $empresas[array_rand($empresas)],
                'classificacao_id' => $classificacoes[3] ?? 4,
                'tipo_material' => 'Gesso',
                'descricao' => 'Placas de gesso para reciclagem',
                'quantidade' => 950.000,
                'unidade_id' => $unidades[0] ?? 1,
                'status' => 'finalizado',
                'endereco' => 'Rua da Construção, 200',
                'cidade' => 'Belo Horizonte',
                'estado' => 'MG',
                'latitude' => -19.9166810,
                'longitude' => -43.9344930,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];
        
        DB::table('residuos')->insert($residuos);
    }
}