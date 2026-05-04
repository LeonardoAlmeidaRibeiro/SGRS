<?php

namespace App\Http\Controllers;

use App\Models\Impacto;
use App\Models\Transacao;
use App\Services\ImpactoCalculatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImpactoController extends Controller
{
    public function index()
    {
        $impactos = Impacto::with('transacao.residuo')->latest()->paginate(15);

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

        Impacto::create($validator->validated());

        return redirect()->route('impactos.index')->with('swal_success', 'Impacto cadastrado com sucesso!');
    }

    public function calcular(Transacao $transacao, ImpactoCalculatorService $impactoService)
    {
        $transacao->impacto()->updateOrCreate([], $impactoService->calcular($transacao));

        return redirect()->route('impactos.index')->with('swal_success', 'Impacto calculado pelo microserviço Python com sucesso!');
    }

    public function edit(Impacto $impacto)
    {
        return view('painel.impactos.form', array_merge($this->options(), compact('impacto')));
    }

    public function update(Request $request, Impacto $impacto)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $impacto->update($validator->validated());

        return redirect()->route('impactos.index')->with('swal_success', 'Impacto atualizado com sucesso!');
    }

    public function destroy(Impacto $impacto)
    {
        $impacto->delete();

        return redirect()->route('impactos.index')->with('swal_success', 'Impacto excluído com sucesso!');
    }

    private function options(): array
    {
        return ['transacoes' => Transacao::with('residuo')->latest()->get()];
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
}
