<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Empresa;
use App\Models\Transacao;
use App\Services\ReputacaoEmpresaService;
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

    public function store(Request $request, ReputacaoEmpresaService $reputacaoService)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $avaliacao = Avaliacao::create($this->data($request, $validator->validated()));
        $reputacaoService->recalcular($avaliacao->empresaAvaliada);

        return redirect()->route('avaliacoes.index')->with('swal_success', 'Avaliacao cadastrada com sucesso!');
    }

    public function edit(Avaliacao $avaliacao)
    {
        return view('painel.avaliacoes.form', array_merge($this->options(), compact('avaliacao')));
    }

    public function update(Request $request, Avaliacao $avaliacao, ReputacaoEmpresaService $reputacaoService)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $empresaAnterior = $avaliacao->empresaAvaliada;
        $avaliacao->update($this->data($request, $validator->validated()));
        $reputacaoService->recalcular($avaliacao->empresaAvaliada);

        if ($empresaAnterior && (int) $empresaAnterior->id !== (int) $avaliacao->empresa_avaliada_id) {
            $reputacaoService->recalcular($empresaAnterior);
        }

        return redirect()->route('avaliacoes.index')->with('swal_success', 'Avaliacao atualizada com sucesso!');
    }

    public function destroy(Avaliacao $avaliacao, ReputacaoEmpresaService $reputacaoService)
    {
        $empresa = $avaliacao->empresaAvaliada;
        $avaliacao->delete();

        if ($empresa) {
            $reputacaoService->recalcular($empresa);
        }

        return redirect()->route('avaliacoes.index')->with('swal_success', 'Avaliacao excluida com sucesso!');
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
            'residuo_conforme' => ['nullable', 'boolean'],
            'comentario' => ['nullable', 'string'],
        ];
    }

    private function data(Request $request, array $validated): array
    {
        $validated['residuo_conforme'] = $request->has('residuo_conforme')
            ? $request->boolean('residuo_conforme')
            : null;

        return $validated;
    }

    private function messages(): array
    {
        return [
            '*.required' => 'Preencha todos os campos obrigatorios.',
            '*.exists' => 'Informe um registro valido.',
            'nota.between' => 'A nota deve ser de 1 a 5.',
        ];
    }
}
