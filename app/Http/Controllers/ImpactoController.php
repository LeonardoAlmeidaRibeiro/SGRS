<?php

namespace App\Http\Controllers;

use App\Models\Impacto;
use App\Models\Transacao;
use App\Services\ImpactoCalculatorService;
use App\Support\EmpresaScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImpactoController extends Controller
{
    use EmpresaScope;

    public function index()
    {
        $query = Impacto::with('transacao.residuo');
        if ($this->empresaLogadaId()) {
            $query->whereHas('transacao', function ($transacao) {
                $this->escopoTransacaoEmpresa($transacao);
            });
        }
        $impactos = $query->latest()->paginate(15);

        return view('painel.impactos.index', compact('impactos'));
    }

    public function create()
    {
        return view('painel.impactos.form', $this->options());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $transacao = Transacao::find($validator->validated()['transacao_id']);
        $this->autorizarTransacao($transacao);

        Impacto::create($validator->validated());

        return redirect()->route('impactos.index')->with('swal_success', 'Impacto cadastrado com sucesso!');
    }

    public function calcular(Transacao $transacao, ImpactoCalculatorService $impactoService)
    {
        $this->autorizarTransacao($transacao);

        $transacao->impacto()->updateOrCreate([], $impactoService->calcular($transacao));

        return redirect()->route('impactos.index')->with('swal_success', 'Impacto calculado pelo microserviço Python com sucesso!');
    }

    public function edit(Impacto $impacto)
    {
        $this->autorizarImpacto($impacto);

        return view('painel.impactos.form', array_merge($this->options(), compact('impacto')));
    }

    public function update(Request $request, Impacto $impacto)
    {
        $this->autorizarImpacto($impacto);

        $validator = Validator::make($request->all(), $this->rules(), $this->messages());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $transacao = Transacao::find($validator->validated()['transacao_id']);
        $this->autorizarTransacao($transacao);

        $impacto->update($validator->validated());

        return redirect()->route('impactos.index')->with('swal_success', 'Impacto atualizado com sucesso!');
    }

    public function destroy(Impacto $impacto)
    {
        $this->autorizarImpacto($impacto);

        $impacto->delete();

        return redirect()->route('impactos.index')->with('swal_success', 'Impacto excluído com sucesso!');
    }

    private function options(): array
    {
        return ['transacoes' => $this->escopoTransacaoEmpresa(Transacao::with('residuo'))->latest()->get()];
    }

    private function rules(): array
    {
        return [
            'transacao_id' => ['required', 'exists:transacoes,id'],
            'co2_economizado' => ['required', 'numeric', 'min:0'],
            'agua_economizada' => ['required', 'numeric', 'min:0'],
            'energia_economizada' => ['required', 'numeric', 'min:0'],
            'valor_economizado' => ['required', 'numeric', 'min:0'],
        ];
    }

    private function messages(): array
    {
        return [
            '*.required' => 'Preencha todos os campos obrigatórios.',
            '*.numeric' => 'Informe apenas números nos campos de impacto.',
            '*.min' => 'Os valores não podem ser negativos.',
        ];
    }

    private function autorizarImpacto(Impacto $impacto): void
    {
        $impacto->loadMissing('transacao');
        $this->autorizarTransacao($impacto->transacao);
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
            abort(403, 'Impacto nao pertence a empresa logada.');
        }
    }
}
