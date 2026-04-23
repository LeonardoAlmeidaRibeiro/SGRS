<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ClassificacoesResiduoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $classificacoes = [
            // Resíduos Perigosos
            [
                'nome' => 'Classe I - Resíduos Perigosos',
                'codigo' => 'NBR10004/I',
                'exige_mtr' => true,
                'exige_cadri' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Produtos Químicos Perigosos',
                'codigo' => 'NBR10004/I-A',
                'exige_mtr' => true,
                'exige_cadri' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Resíduos Infectantes',
                'codigo' => 'NBR10004/I-B',
                'exige_mtr' => true,
                'exige_cadri' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Resíduos Não Perigosos
            [
                'nome' => 'Classe II - Resíduos Não Perigosos',
                'codigo' => 'NBR10004/II',
                'exige_mtr' => false,
                'exige_cadri' => false,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Resíduos Recicláveis',
                'codigo' => 'NBR10004/II-A',
                'exige_mtr' => false,
                'exige_cadri' => false,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Resíduos Orgânicos',
                'codigo' => 'NBR10004/II-B',
                'exige_mtr' => false,
                'exige_cadri' => false,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Resíduos Sólidos Urbanos',
                'codigo' => 'NBR10004/II-C',
                'exige_mtr' => false,
                'exige_cadri' => false,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Resíduos Inertes
            [
                'nome' => 'Classe III - Resíduos Inertes',
                'codigo' => 'NBR10004/III',
                'exige_mtr' => false,
                'exige_cadri' => false,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Entulho de Construção Civil',
                'codigo' => 'NBR10004/III-A',
                'exige_mtr' => false,
                'exige_cadri' => false,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Resíduos de Demolição',
                'codigo' => 'NBR10004/III-B',
                'exige_mtr' => false,
                'exige_cadri' => false,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Específicos por tipo de resíduo
            [
                'nome' => 'Resíduos de Serviços de Saúde (RSS)',
                'codigo' => 'RDC-222/2018',
                'exige_mtr' => true,
                'exige_cadri' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Resíduos Eletroeletrônicos',
                'codigo' => 'PNRS/2010',
                'exige_mtr' => false,
                'exige_cadri' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Óleos Lubrificantes Usados',
                'codigo' => 'CONAMA 450/2012',
                'exige_mtr' => true,
                'exige_cadri' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Pilhas e Baterias',
                'codigo' => 'CONAMA 401/2008',
                'exige_mtr' => true,
                'exige_cadri' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Resíduos Agrossilvopastoris',
                'codigo' => 'NBR10004/IV',
                'exige_mtr' => false,
                'exige_cadri' => false,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Lâmpadas Fluorescentes',
                'codigo' => 'CONAMA 401/2008',
                'exige_mtr' => true,
                'exige_cadri' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Resíduos Têxteis',
                'codigo' => 'NBR10004/V',
                'exige_mtr' => false,
                'exige_cadri' => false,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Resíduos Plásticos',
                'codigo' => 'PNRS/2010',
                'exige_mtr' => false,
                'exige_cadri' => false,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Resíduos Metálicos',
                'codigo' => 'NBR10004/VI',
                'exige_mtr' => false,
                'exige_cadri' => false,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Resíduos de Papel e Papelão',
                'codigo' => 'PNRS/2010',
                'exige_mtr' => false,
                'exige_cadri' => false,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Resíduos de Madeira',
                'codigo' => 'NBR10004/VII',
                'exige_mtr' => false,
                'exige_cadri' => false,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Resíduos de Vidro',
                'codigo' => 'PNRS/2010',
                'exige_mtr' => false,
                'exige_cadri' => false,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Resíduos Radioativos',
                'codigo' => 'CNEN-NE-6.05',
                'exige_mtr' => true,
                'exige_cadri' => true,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'nome' => 'Resíduos de Pneus',
                'codigo' => 'CONAMA 416/2009',
                'exige_mtr' => true,
                'exige_cadri' => true,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('classificacoes_residuo')->insert($classificacoes);
    }
}
