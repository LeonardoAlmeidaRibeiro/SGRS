<?php

namespace Database\Seeders;

use App\Models\Avaliacao;
use App\Models\ClassificacaoResiduo;
use App\Models\DocumentoTransacao;
use App\Models\Empresa;
use App\Models\Impacto;
use App\Models\Interesse;
use App\Models\RastreabilidadeLog;
use App\Models\Residuo;
use App\Models\Transacao;
use App\Models\UnidadeMedida;
use App\Models\User;
use App\Services\CalculoCarbonoService;
use App\Services\ReputacaoEmpresaService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSgrsSeeder extends Seeder
{
    public function run(): void
    {
        $empresas = $this->criarEmpresasEFuncionarios();
        $classificacoes = ClassificacaoResiduo::orderBy('id')->take(8)->get()->values();
        $unidades = UnidadeMedida::orderBy('id')->take(3)->get()->values();

        if ($classificacoes->isEmpty() || $unidades->isEmpty()) {
            return;
        }

        $this->atualizarClassificacoesLegais($classificacoes);

        $residuos = $this->criarResiduos($empresas, $classificacoes, $unidades);
        $this->criarInteresses($empresas, $classificacoes);
        $transacoes = $this->criarTransacoes($residuos, $empresas);
        $this->criarDocumentos($transacoes);
        $this->criarImpactos($transacoes);
        $this->criarAvaliacoes($transacoes);
    }

    private function criarEmpresasEFuncionarios()
    {
        $dados = [
            [
                'nome' => 'EcoPlast Reciclagem',
                'email' => 'contato@ecoplast.test',
                'tipo_industria' => 'Reciclagem de plastico',
                'cnpj' => '11.111.111/0001-11',
                'telefone' => '(11) 91111-1111',
                'cep' => '01001-000',
                'endereco' => 'Av. Paulista',
                'numero' => '1000',
                'cidade' => 'Sao Paulo',
                'estado' => 'SP',
                'latitude' => -23.561684,
                'longitude' => -46.655981,
                'possui_licenca_ambiental' => true,
                'licenca_residuos_perigosos' => false,
                'numero_licenca_ambiental' => 'LA-SP-1001',
                'validade_licenca_ambiental' => now()->addYears(2)->toDateString(),
                'licenca_ambiental_url' => 'https://example.com/licencas/ecoplast.pdf',
                'usuarios' => [
                    ['name' => 'Ana EcoPlast', 'email' => 'ana@ecoplast.test', 'perfil' => 'admin'],
                    ['name' => 'Bruno EcoPlast', 'email' => 'bruno@ecoplast.test', 'perfil' => 'operador'],
                ],
            ],
            [
                'nome' => 'MetalVale Industrial',
                'email' => 'contato@metalvale.test',
                'tipo_industria' => 'Metalurgia',
                'cnpj' => '22.222.222/0001-22',
                'telefone' => '(31) 92222-2222',
                'cep' => '32010-000',
                'endereco' => 'Av. Metalurgica',
                'numero' => '800',
                'cidade' => 'Contagem',
                'estado' => 'MG',
                'latitude' => -19.932,
                'longitude' => -44.053,
                'possui_licenca_ambiental' => true,
                'licenca_residuos_perigosos' => true,
                'numero_licenca_ambiental' => 'LA-MG-2202',
                'validade_licenca_ambiental' => now()->addYears(2)->toDateString(),
                'licenca_ambiental_url' => 'https://example.com/licencas/metalvale.pdf',
                'usuarios' => [
                    ['name' => 'Carla MetalVale', 'email' => 'carla@metalvale.test', 'perfil' => 'admin'],
                    ['name' => 'Diego MetalVale', 'email' => 'diego@metalvale.test', 'perfil' => 'operador'],
                ],
            ],
            [
                'nome' => 'BioComposta Alimentos',
                'email' => 'contato@biocomposta.test',
                'tipo_industria' => 'Alimentos',
                'cnpj' => '33.333.333/0001-33',
                'telefone' => '(41) 93333-3333',
                'cep' => '80010-000',
                'endereco' => 'Rua Verde',
                'numero' => '450',
                'cidade' => 'Curitiba',
                'estado' => 'PR',
                'latitude' => -25.428954,
                'longitude' => -49.267137,
                'possui_licenca_ambiental' => true,
                'licenca_residuos_perigosos' => false,
                'numero_licenca_ambiental' => 'LA-PR-3303',
                'validade_licenca_ambiental' => now()->addYears(2)->toDateString(),
                'licenca_ambiental_url' => 'https://example.com/licencas/biocomposta.pdf',
                'usuarios' => [
                    ['name' => 'Elisa BioComposta', 'email' => 'elisa@biocomposta.test', 'perfil' => 'admin'],
                    ['name' => 'Felipe BioComposta', 'email' => 'felipe@biocomposta.test', 'perfil' => 'operador'],
                ],
            ],
        ];

        $empresas = collect();

        foreach ($dados as $item) {
            $usuarios = $item['usuarios'];
            unset($item['usuarios']);

            $empresa = Empresa::updateOrCreate(
                ['cnpj' => $item['cnpj']],
                $item
            );

            foreach ($usuarios as $usuario) {
                User::updateOrCreate(
                    ['email' => $usuario['email']],
                    [
                        'empresa_id' => $empresa->id,
                        'name' => $usuario['name'],
                        'password' => Hash::make('123456'),
                        'perfil' => $usuario['perfil'],
                        'telefone' => $empresa->telefone,
                        'cidade' => $empresa->cidade,
                        'estado' => $empresa->estado,
                    ]
                );
            }

            $empresas->push($empresa);
        }

        return $empresas;
    }

    private function atualizarClassificacoesLegais($classificacoes): void
    {
        foreach ($classificacoes as $index => $classificacao) {
            $perigoso = in_array($index, [0, 2], true);
            $classificacao->update([
                'classe_nbr10004' => $perigoso ? 'perigoso' : 'nao_perigoso',
                'codigo_cer' => 'CER-' . str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                'exige_mtr' => $perigoso ? true : $classificacao->exige_mtr,
                'exige_cadri' => $perigoso ? true : $classificacao->exige_cadri,
            ]);
        }
    }

    private function criarResiduos($empresas, $classificacoes, $unidades)
    {
        $imagens = [
            'plastico' => 'https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?auto=format&fit=crop&w=900&q=80',
            'metal' => 'https://placehold.co/900x600/eef1f4/5f6b76?text=Sucata+Metalica',
            'organico' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=900&q=80',
            'papel' => 'https://images.unsplash.com/photo-1595079676339-1534801ad6cf?auto=format&fit=crop&w=900&q=80',
            'vidro' => 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=900&q=80',
            'madeira' => 'https://images.unsplash.com/photo-1523413651479-597eb2da0ad6?auto=format&fit=crop&w=900&q=80',
        ];

        $dados = [
            [
                'empresa' => $empresas[0],
                'classificacao' => $classificacoes[0],
                'tipo_material' => 'Plastico PEAD limpo',
                'descricao' => 'Lotes de bombonas e aparas plasticas separados para reciclagem.',
                'imagem' => $imagens['plastico'],
                'quantidade' => 1800.000,
                'unidade' => $unidades[0],
                'status' => 'disponivel',
            ],
            [
                'empresa' => $empresas[0],
                'classificacao' => $classificacoes[1] ?? $classificacoes[0],
                'tipo_material' => 'Papelao prensado',
                'descricao' => 'Fardos de papelao seco, prontos para reaproveitamento.',
                'imagem' => $imagens['papel'],
                'quantidade' => 950.000,
                'unidade' => $unidades[0],
                'status' => 'finalizado',
            ],
            [
                'empresa' => $empresas[1],
                'classificacao' => $classificacoes[2] ?? $classificacoes[0],
                'tipo_material' => 'Sucata Metalica',
                'descricao' => 'Retalhos de ferro, aco e aluminio separados por lote.',
                'imagem' => $imagens['metal'],
                'quantidade' => 4200.000,
                'unidade' => $unidades[0],
                'status' => 'disponivel',
            ],
            [
                'empresa' => $empresas[1],
                'classificacao' => $classificacoes[3] ?? $classificacoes[0],
                'tipo_material' => 'Madeira de paletes',
                'descricao' => 'Paletes avariados para reuso em fabricacao de cavacos.',
                'imagem' => $imagens['madeira'],
                'quantidade' => 760.000,
                'unidade' => $unidades[0],
                'status' => 'reservado',
            ],
            [
                'empresa' => $empresas[2],
                'classificacao' => $classificacoes[4] ?? $classificacoes[0],
                'tipo_material' => 'Residuo Organico',
                'descricao' => 'Sobras vegetais e cascas para compostagem industrial.',
                'imagem' => $imagens['organico'],
                'quantidade' => 2300.000,
                'unidade' => $unidades[0],
                'status' => 'disponivel',
            ],
            [
                'empresa' => $empresas[2],
                'classificacao' => $classificacoes[5] ?? $classificacoes[0],
                'tipo_material' => 'Vidro transparente',
                'descricao' => 'Cacos de vidro limpos e separados por cor.',
                'imagem' => $imagens['vidro'],
                'quantidade' => 610.000,
                'unidade' => $unidades[0],
                'status' => 'reservado',
            ],
        ];

        return collect($dados)->map(function ($item) {
            return Residuo::updateOrCreate(
                [
                    'empresa_id' => $item['empresa']->id,
                    'tipo_material' => $item['tipo_material'],
                ],
                [
                    'classificacao_id' => $item['classificacao']->id,
                    'descricao' => $item['descricao'],
                    'imagem' => $item['imagem'],
                    'quantidade' => $item['quantidade'],
                    'unidade_id' => $item['unidade']->id,
                    'status' => $item['status'],
                    'endereco' => $item['empresa']->endereco . ', ' . $item['empresa']->numero,
                    'cidade' => $item['empresa']->cidade,
                    'estado' => $item['empresa']->estado,
                    'latitude' => $item['empresa']->latitude,
                    'longitude' => $item['empresa']->longitude,
                    'mtr_url' => 'https://example.com/documentos/mtr-residuo-' . strtolower(str_replace(' ', '-', $item['tipo_material'])) . '.pdf',
                    'licenca_ambiental_url' => $item['empresa']->licenca_ambiental_url,
                    'checklist_origem_preenchido' => true,
                    'checklist_quantidade_confirmada' => true,
                    'checklist_acondicionamento_confirmado' => true,
                    'checklist_documentos_conferidos' => true,
                    'assinatura_digital' => 'Seed Demo - Responsavel Legal',
                    'checklist_assinado_em' => now(),
                    'documentacao_validada' => true,
                    'observacao_validacao' => 'Validacao automatica por seed de demonstracao.',
                ]
            );
        });
    }

    private function criarInteresses($empresas, $classificacoes): void
    {
        $dados = [
            [$empresas[0], 'Sucata Metalica', $classificacoes[2] ?? $classificacoes[0], 500, 5000, 800],
            [$empresas[0], 'Residuo Organico', $classificacoes[4] ?? $classificacoes[0], 300, 3000, 600],
            [$empresas[1], 'Plastico', $classificacoes[0], 200, 2500, 700],
            [$empresas[1], 'Vidro', $classificacoes[5] ?? $classificacoes[0], 100, 1200, 900],
            [$empresas[2], 'Papelao', $classificacoes[1] ?? $classificacoes[0], 250, 2000, 900],
            [$empresas[2], 'Madeira', $classificacoes[3] ?? $classificacoes[0], 200, 1500, 500],
        ];

        foreach ($dados as $item) {
            Interesse::updateOrCreate(
                [
                    'empresa_id' => $item[0]->id,
                    'tipo_material' => $item[1],
                    'classificacao_id' => $item[2]->id,
                ],
                [
                    'quantidade_minima' => $item[3],
                    'quantidade_maxima' => $item[4],
                    'raio_km' => $item[5],
                ]
            );
        }
    }

    private function criarTransacoes($residuos, $empresas)
    {
        $dados = [
            [$residuos[1], $empresas[0], $empresas[2], 'concluido', now()->subDays(18)->toDateString()],
            [$residuos[3], $empresas[1], $empresas[2], 'pendente', now()->subDays(5)->toDateString()],
            [$residuos[5], $empresas[2], $empresas[1], 'aprovado', now()->subDays(9)->toDateString()],
        ];

        $transacoes = collect($dados)->map(function ($item) {
            return Transacao::updateOrCreate(
                [
                    'residuo_id' => $item[0]->id,
                    'empresa_origem_id' => $item[1]->id,
                    'empresa_destino_id' => $item[2]->id,
                ],
                [
                    'status' => $item[3],
                    'data_transacao' => $item[4],
                    'data_recebimento' => $item[3] === 'concluido' ? now()->subDays(15) : null,
                    'codigo_rastreio' => 'TRC-SEED-' . str_pad($item[0]->id, 5, '0', STR_PAD_LEFT),
                    'hash_rastreio' => hash('sha256', 'TRC-SEED-' . $item[0]->id . '-' . $item[3]),
                ]
            );
        });

        foreach ($transacoes as $transacao) {
            $this->criarLogRastreabilidade($transacao, 'transacao_seed', 'Transacao criada pelo seed de demonstracao.');
        }

        return $transacoes;
    }

    private function criarLogRastreabilidade(Transacao $transacao, string $acao, string $descricao): void
    {
        RastreabilidadeLog::updateOrCreate(
            [
                'transacao_id' => $transacao->id,
                'acao' => $acao,
            ],
            [
                'empresa_id' => $transacao->empresa_origem_id,
                'user_id' => null,
                'descricao' => $descricao,
                'documento_url' => optional($transacao->residuo)->mtr_url,
                'hash_evento' => hash('sha256', $transacao->codigo_rastreio . '|' . $acao . '|' . $descricao),
            ]
        );
    }

    private function criarDocumentos($transacoes): void
    {
        foreach ($transacoes as $transacao) {
            DocumentoTransacao::updateOrCreate(
                [
                    'transacao_id' => $transacao->id,
                    'tipo_documento' => 'MTR',
                ],
                [
                    'numero_documento' => 'MTR-' . str_pad($transacao->id, 5, '0', STR_PAD_LEFT),
                    'arquivo_url' => 'https://example.com/documentos/mtr-' . $transacao->id . '.pdf',
                    'data_emissao' => now()->subDays(10)->toDateString(),
                    'data_validade' => now()->addMonths(6)->toDateString(),
                    'status_validacao' => 'valido',
                ]
            );

            DocumentoTransacao::updateOrCreate(
                [
                    'transacao_id' => $transacao->id,
                    'tipo_documento' => 'nota_fiscal',
                ],
                [
                    'numero_documento' => 'NF-' . str_pad($transacao->id, 5, '0', STR_PAD_LEFT),
                    'arquivo_url' => 'https://example.com/documentos/nf-' . $transacao->id . '.pdf',
                    'data_emissao' => now()->subDays(8)->toDateString(),
                    'data_validade' => null,
                    'status_validacao' => $transacao->status === 'pendente' ? 'pendente' : 'valido',
                ]
            );
        }
    }

    private function criarImpactos($transacoes): void
    {
        $servico = new CalculoCarbonoService();

        foreach ($transacoes as $transacao) {
            Impacto::updateOrCreate(
                ['transacao_id' => $transacao->id],
                $servico->calcularPorTransacao($transacao)
            );
        }
    }

    private function criarAvaliacoes($transacoes): void
    {
        foreach ($transacoes as $transacao) {
            if ($transacao->status !== 'concluido') {
                continue;
            }

            Avaliacao::updateOrCreate(
                [
                    'transacao_id' => $transacao->id,
                    'empresa_avaliadora_id' => $transacao->empresa_destino_id,
                    'empresa_avaliada_id' => $transacao->empresa_origem_id,
                ],
                [
                    'nota' => 5,
                    'residuo_conforme' => true,
                    'comentario' => 'Transacao concluida com documentacao organizada e bom aproveitamento do residuo.',
                ]
            );

            (new ReputacaoEmpresaService())->recalcular($transacao->empresaOrigem);
        }
    }
}
