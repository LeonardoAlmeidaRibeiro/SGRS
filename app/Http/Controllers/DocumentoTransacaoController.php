<?php

namespace App\Http\Controllers;

use App\Models\DocumentoTransacao;
use App\Models\Transacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentoTransacaoController extends Controller
{
    public function index()
    {
        $documentos = DocumentoTransacao::with('transacao.residuo')->latest()->paginate(15);

        return view('painel.documentos_transacao.index', compact('documentos'));
    }

    public function create()
    {
        return view('painel.documentos_transacao.form', $this->options());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DocumentoTransacao::create($validator->validated());

        return redirect()->route('documentos-transacao.index')->with('swal_success', 'Documento cadastrado com sucesso!');
    }

    public function show(DocumentoTransacao $documentoTransacao)
    {
        $documentoTransacao->load('transacao.residuo');

        return view('painel.documentos_transacao.visualizar', ['documento' => $documentoTransacao]);
    }

    public function edit(DocumentoTransacao $documentoTransacao)
    {
        return view('painel.documentos_transacao.form', array_merge($this->options(), ['documento' => $documentoTransacao]));
    }

    public function update(Request $request, DocumentoTransacao $documentoTransacao)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $documentoTransacao->update($validator->validated());

        return redirect()->route('documentos-transacao.index')->with('swal_success', 'Documento atualizado com sucesso!');
    }

    public function destroy(DocumentoTransacao $documentoTransacao)
    {
        $documentoTransacao->delete();

        return redirect()->route('documentos-transacao.index')->with('swal_success', 'Documento excluído com sucesso!');
    }

    private function options(): array
    {
        return [
            'transacoes' => Transacao::with('residuo')->latest()->get(),
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
}
