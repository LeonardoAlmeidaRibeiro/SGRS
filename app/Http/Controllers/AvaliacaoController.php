<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Empresa;
use App\Models\Transacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AvaliacaoController extends Controller
{
    public function index()
    {
        $avaliacoes = Avaliacao::with(['transacao.residuo', 'empresaAvaliadora', 'empresaAvaliada'])->latest()->paginate(15);

        return view('painel.avaliacoes.index', compact('avaliacoes'));
    }

    public function create()
    {
        return view('painel.avaliacoes.form', $this->options());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Avaliacao::create($validator->validated());

        return redirect()->route('avaliacoes.index')->with('swal_success', 'Avaliação cadastrada com sucesso!');
    }

    public function edit(Avaliacao $avaliacao)
    {
        return view('painel.avaliacoes.form', array_merge($this->options(), compact('avaliacao')));
    }

    public function update(Request $request, Avaliacao $avaliacao)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $avaliacao->update($validator->validated());

        return redirect()->route('avaliacoes.index')->with('swal_success', 'Avaliação atualizada com sucesso!');
    }

    public function destroy(Avaliacao $avaliacao)
    {
        $avaliacao->delete();

        return redirect()->route('avaliacoes.index')->with('swal_success', 'Avaliação excluída com sucesso!');
    }

    private function options(): array
    {
        return [
            'transacoes' => Transacao::with('residuo')->latest()->get(),
            'empresas' => Empresa::orderBy('nome')->get(),
        ];
    }

    private function rules(): array
    {
        return [
            'transacao_id' => ['required', 'exists:transacoes,id'],
            'empresa_avaliadora_id' => ['required', 'exists:empresas,id'],
            'empresa_avaliada_id' => ['required', 'exists:empresas,id'],
            'nota' => ['required', 'integer', 'between:1,5'],
            'comentario' => ['nullable', 'string'],
        ];
    }

    private function messages(): array
    {
        return [
            '*.required' => 'Preencha todos os campos obrigatórios.',
            '*.exists' => 'Informe um registro válido.',
            'nota.between' => 'A nota deve ser de 1 a 5.',
        ];
    }
}
