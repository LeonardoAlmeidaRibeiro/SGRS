<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Residuo;
use App\Models\Transacao;
use App\Services\ImpactoCalculatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransacaoController extends Controller
{
    public function index()
    {
        $transacoes = Transacao::with(['residuo', 'empresaOrigem', 'empresaDestino'])->latest()->paginate(15);

        return view('painel.transacoes.index', compact('transacoes'));
    }

    public function create()
    {
        return view('painel.transacoes.form', $this->options());
    }

    public function store(Request $request, ImpactoCalculatorService $impactoService)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $transacao = Transacao::create($validator->validated());
        $this->sincronizarResiduo($transacao);
        $this->calcularImpacto($transacao, $impactoService);

        return redirect()->route('transacoes.index')->with('swal_success', 'Transação cadastrada com sucesso!');
    }

    public function show(Transacao $transacao)
    {
        $transacao->load(['residuo.unidade', 'empresaOrigem', 'empresaDestino', 'documentos', 'impacto', 'avaliacoes']);

        return view('painel.transacoes.visualizar', compact('transacao'));
    }

    public function edit(Transacao $transacao)
    {
        return view('painel.transacoes.form', array_merge($this->options(), compact('transacao')));
    }

    public function update(Request $request, Transacao $transacao, ImpactoCalculatorService $impactoService)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $transacao->update($validator->validated());
        $this->sincronizarResiduo($transacao);
        $this->calcularImpacto($transacao, $impactoService);

        return redirect()->route('transacoes.index')->with('swal_success', 'Transação atualizada com sucesso!');
    }

    public function destroy(Transacao $transacao)
    {
        $transacao->delete();

        return redirect()->route('transacoes.index')->with('swal_success', 'Transação excluída com sucesso!');
    }

    private function options(): array
    {
        return [
            'residuos' => Residuo::with('empresa')->orderBy('tipo_material')->get(),
            'empresas' => Empresa::orderBy('nome')->get(),
            'statusOptions' => ['pendente' => 'Pendente', 'aprovado' => 'Aprovado', 'concluido' => 'Concluído', 'cancelado' => 'Cancelado'],
        ];
    }

    private function rules(): array
    {
        return [
            'residuo_id' => ['required', 'exists:residuos,id'],
            'empresa_origem_id' => ['required', 'exists:empresas,id'],
            'empresa_destino_id' => ['required', 'exists:empresas,id'],
            'status' => ['required', 'in:pendente,aprovado,concluido,cancelado'],
            'data_transacao' => ['nullable', 'date'],
        ];
    }

    private function messages(): array
    {
        return [
            '*.required' => 'Preencha todos os campos obrigatórios.',
            '*.exists' => 'Informe um registro válido.',
            'status.in' => 'Informe um status válido.',
            'data_transacao.date' => 'Informe uma data válida.',
        ];
    }

    private function sincronizarResiduo(Transacao $transacao): void
    {
        switch ($transacao->status) {
            case 'concluido':
                $status = 'finalizado';
                break;
            case 'cancelado':
                $status = 'disponivel';
                break;
            default:
                $status = 'reservado';
                break;
        }

        $transacao->residuo()->update(['status' => $status]);
    }

    private function calcularImpacto(Transacao $transacao, ImpactoCalculatorService $impactoService): void
    {
        if ($transacao->status !== 'cancelado') {
            $transacao->impacto()->updateOrCreate([], $impactoService->calcular($transacao));
        }
    }
}
