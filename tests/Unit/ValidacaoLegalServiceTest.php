<?php

namespace Tests\Unit;

use App\Models\ClassificacaoResiduo;
use App\Models\Empresa;
use App\Models\Residuo;
use App\Services\ValidacaoLegalService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class ValidacaoLegalServiceTest extends TestCase
{
    public function test_residuo_sem_documentacao_nao_deve_ir_para_marketplace(): void
    {
        $residuo = new Residuo([
            'documentacao_validada' => false,
            'mtr_url' => null,
            'licenca_ambiental_url' => null,
        ]);

        $erro = (new ValidacaoLegalService())->validarResiduoParaMarketplace($residuo);

        $this->assertSame('A documentacao legal do residuo ainda nao foi validada.', $erro);
    }

    public function test_classificacao_com_mtr_exige_mtr_no_residuo(): void
    {
        $classificacao = new ClassificacaoResiduo(['exige_mtr' => true]);
        $residuo = new Residuo([
            'documentacao_validada' => true,
            'licenca_ambiental_url' => 'https://example.com/licenca.pdf',
        ]);
        $residuo->setRelation('classificacao', $classificacao);

        $erro = (new ValidacaoLegalService())->validarResiduoParaMarketplace($residuo);

        $this->assertSame('Esta classificacao exige MTR.', $erro);
    }

    public function test_documento_vencido_nao_pode_ser_valido(): void
    {
        $erro = (new ValidacaoLegalService())->documentoPodeSerValido([
            'status_validacao' => 'valido',
            'arquivo_url' => 'https://example.com/mtr.pdf',
            'data_validade' => Carbon::yesterday()->toDateString(),
        ]);

        $this->assertSame('Documento vencido nao pode ser marcado como valido.', $erro);
    }

    public function test_empresa_precisa_de_licenca_especifica_para_residuo_perigoso(): void
    {
        $empresa = new Empresa([
            'possui_licenca_ambiental' => true,
            'licenca_residuos_perigosos' => false,
            'validade_licenca_ambiental' => Carbon::tomorrow(),
        ]);

        $this->assertFalse($empresa->podeReceberResiduoPerigoso());
    }
}
