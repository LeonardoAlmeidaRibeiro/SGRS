<?php

namespace App\Http\Controllers;

use App\Models\DocumentoTransacao;
use App\Models\Transacao;
use App\Services\RastreabilidadeService;
use App\Services\ValidacaoLegalService;
use App\Support\EmpresaScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentoTransacaoController extends Controller
{
    use EmpresaScope;

    public function index()
    {
        $query = DocumentoTransacao::with('transacao.residuo');
        if ($this->empresaLogadaId()) {
            $query->whereHas('transacao', function ($transacao) {
                $this->escopoTransacaoEmpresa($transacao);
            });
        }
        $documentos = $query->latest()->paginate(15);

        return view('painel.documentos_transacao.index', compact('documentos'));
    }

    public function create()
    {
        return view('painel.documentos_transacao.form', $this->options());
    }

    public function store(Request $request, ValidacaoLegalService $validacaoLegalService, RastreabilidadeService $rastreabilidadeService)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $bloqueio = $validacaoLegalService->documentoPodeSerValido($validator->validated());
        if ($bloqueio) {
            return back()->withInput()->with('swal_error', $bloqueio);
        }

        $transacao = Transacao::find($validator->validated()['transacao_id']);
        $this->autorizarTransacao($transacao);

        $documento = DocumentoTransacao::create($validator->validated());
        $rastreabilidadeService->registrar($documento->transacao, 'documento_cadastrado', 'Documento ' . $documento->tipo_documento . ' cadastrado.', $documento->arquivo_url);

        return redirect()->route('documentos-transacao.index')->with('swal_success', 'Documento cadastrado com sucesso!');
    }

    public function show(DocumentoTransacao $documentoTransacao)
    {
        $documentoTransacao->load('transacao.residuo');
        $this->autorizarDocumento($documentoTransacao);

        return view('painel.documentos_transacao.visualizar', ['documento' => $documentoTransacao]);
    }

    public function edit(DocumentoTransacao $documentoTransacao)
    {
        $this->autorizarDocumento($documentoTransacao);

        return view('painel.documentos_transacao.form', array_merge($this->options(), ['documento' => $documentoTransacao]));
    }

    public function update(Request $request, DocumentoTransacao $documentoTransacao, ValidacaoLegalService $validacaoLegalService, RastreabilidadeService $rastreabilidadeService)
    {
        $this->autorizarDocumento($documentoTransacao);

        $validator = Validator::make($request->all(), $this->rules(), $this->messages());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $bloqueio = $validacaoLegalService->documentoPodeSerValido($validator->validated());
        if ($bloqueio) {
            return back()->withInput()->with('swal_error', $bloqueio);
        }

        $transacao = Transacao::find($validator->validated()['transacao_id']);
        $this->autorizarTransacao($transacao);

        $documentoTransacao->update($validator->validated());
        $rastreabilidadeService->registrar($documentoTransacao->transacao, 'documento_atualizado', 'Documento ' . $documentoTransacao->tipo_documento . ' atualizado para ' . $documentoTransacao->status_validacao . '.', $documentoTransacao->arquivo_url);

        return redirect()->route('documentos-transacao.index')->with('swal_success', 'Documento atualizado com sucesso!');
    }

    public function destroy(DocumentoTransacao $documentoTransacao)
    {
        $this->autorizarDocumento($documentoTransacao);

        $documentoTransacao->delete();

        return redirect()->route('documentos-transacao.index')->with('swal_success', 'Documento excluído com sucesso!');
    }

    private function options(): array
    {
        return [
            'transacoes' => $this->escopoTransacaoEmpresa(Transacao::with('residuo'))->latest()->get(),
            'tipos' => ['MTR' => 'MTR', 'CADRI' => 'CADRI', 'nota_fiscal' => 'Nota fiscal', 'contrato' => 'Contrato'],
            'statusOptions' => ['pendente' => 'Pendente', 'valido' => 'Válido', 'vencido' => 'Vencido', 'rejeitado' => 'Rejeitado'],
        ];
    }

    private function rules(): array
    {
        return [
            'transacao_id' => ['required', 'exists:transacoes,id'],
            'tipo_documento' => ['required', 'in:MTR,CADRI,nota_fiscal,contrato'],
            'numero_documento' => ['nullable', 'string', 'max:255'],
            'arquivo_url' => ['nullable', 'url', 'max:255'],
            'data_emissao' => ['nullable', 'date'],
            'data_validade' => ['nullable', 'date'],
            'status_validacao' => ['required', 'in:pendente,valido,vencido,rejeitado'],
        ];
    }

    private function messages(): array
    {
        return [
            '*.required' => 'Preencha todos os campos obrigatórios.',
            '*.exists' => 'Informe um registro válido.',
            '*.date' => 'Informe uma data válida.',
            'arquivo_url.url' => 'Informe uma URL válida para o arquivo.',
        ];
    }

    private function autorizarDocumento(DocumentoTransacao $documento): void
    {
        if (!$documento->relationLoaded('transacao')) {
            $documento->load('transacao');
        }

        $empresaId = $this->empresaLogadaId();

        if (!$empresaId) {
            return;
        }

        $transacao = $documento->transacao;
        if (!$transacao || !in_array((int) $empresaId, [
            (int) $transacao->empresa_origem_id,
            (int) $transacao->empresa_destino_id,
            (int) $transacao->empresa_transportadora_id,
        ], true)) {
            abort(403, 'Documento nao pertence a empresa logada.');
        }
    }

    private function autorizarTransacao(?Transacao $transacao): void
    {
        if (!$transacao) {
            abort(403, 'Transacao nao encontrada.');
        }

        $empresaId = $this->empresaLogadaId();

        if (!$empresaId) {
            return;
        }

        if (!in_array((int) $empresaId, [
            (int) $transacao->empresa_origem_id,
            (int) $transacao->empresa_destino_id,
            (int) $transacao->empresa_transportadora_id,
        ], true)) {
            abort(403, 'Transacao nao pertence a empresa logada.');
        }
    }
}
