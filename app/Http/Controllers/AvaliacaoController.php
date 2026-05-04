<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Empresa;
use App\Models\Transacao;
use App\Services\ReputacaoEmpresaService;
use App\Support\EmpresaScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AvaliacaoController extends Controller
{
    use EmpresaScope;

    public function index()
    {
        $query = Avaliacao::with(['transacao.residuo', 'empresaAvaliadora', 'empresaAvaliada']);
        if ($this->empresaLogadaId()) {
            $query->where(function ($q) {
                $q->where('empresa_avaliadora_id', $this->empresaLogadaId())
                    ->orWhere('empresa_avaliada_id', $this->empresaLogadaId());
            });
        }
        $avaliacoes = $query->latest()->paginate(15);

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

        $dados = $this->data($request, $validator->validated());
        $bloqueio = $this->validarAvaliacao($dados);
        if ($bloqueio) {
            return back()->withInput()->with('swal_error', $bloqueio);
        }

        $avaliacao = Avaliacao::create($dados);
        $reputacaoService->recalcular($avaliacao->empresaAvaliada);

        return redirect()->route('avaliacoes.index')->with('swal_success', 'Avaliacao cadastrada com sucesso!');
    }

    public function edit(Avaliacao $avaliacao)
    {
        $this->autorizarAvaliacao($avaliacao);

        return view('painel.avaliacoes.form', array_merge($this->options(), compact('avaliacao')));
    }

    public function update(Request $request, Avaliacao $avaliacao, ReputacaoEmpresaService $reputacaoService)
    {
        $this->autorizarAvaliacao($avaliacao);

        $validator = Validator::make($request->all(), $this->rules(), $this->messages());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dados = $this->data($request, $validator->validated());
        $bloqueio = $this->validarAvaliacao($dados);
        if ($bloqueio) {
            return back()->withInput()->with('swal_error', $bloqueio);
        }

        $empresaAnterior = $avaliacao->empresaAvaliada;
        $avaliacao->update($dados);
        $reputacaoService->recalcular($avaliacao->empresaAvaliada);

        if ($empresaAnterior && (int) $empresaAnterior->id !== (int) $avaliacao->empresa_avaliada_id) {
            $reputacaoService->recalcular($empresaAnterior);
        }

        return redirect()->route('avaliacoes.index')->with('swal_success', 'Avaliacao atualizada com sucesso!');
    }

    public function destroy(Avaliacao $avaliacao, ReputacaoEmpresaService $reputacaoService)
    {
        $this->autorizarAvaliacao($avaliacao);

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
            'transacoes' => $this->escopoTransacaoEmpresa(Transacao::with('residuo'))->latest()->get(),
            'empresas' => $this->empresasRelacionadas(),
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

        if ($this->empresaLogadaId()) {
            $validated['empresa_avaliadora_id'] = $this->empresaLogadaId();
        }

        return $validated;
    }

    private function validarAvaliacao(array $dados): ?string
    {
        $transacao = Transacao::find($dados['transacao_id']);
        if (!$transacao) {
            return 'Informe uma transacao valida.';
        }

        $empresaId = $this->empresaLogadaId();
        if ($empresaId && !in_array((int) $empresaId, [
            (int) $transacao->empresa_origem_id,
            (int) $transacao->empresa_destino_id,
        ], true)) {
            return 'A avaliacao precisa estar vinculada a uma transacao da empresa logada.';
        }

        if (!in_array((int) $dados['empresa_avaliada_id'], [
            (int) $transacao->empresa_origem_id,
            (int) $transacao->empresa_destino_id,
        ], true)) {
            return 'A empresa avaliada precisa fazer parte da transacao.';
        }

        return null;
    }

    private function empresasRelacionadas()
    {
        if (!$this->empresaLogadaId()) {
            return Empresa::orderBy('nome')->get();
        }

        $transacoes = $this->escopoTransacaoEmpresa(Transacao::query())->get(['empresa_origem_id', 'empresa_destino_id']);
        $ids = $transacoes->pluck('empresa_origem_id')
            ->merge($transacoes->pluck('empresa_destino_id'))
            ->push($this->empresaLogadaId())
            ->unique()
            ->values();

        return Empresa::whereIn('id', $ids)->orderBy('nome')->get();
    }

    private function messages(): array
    {
        return [
            '*.required' => 'Preencha todos os campos obrigatorios.',
            '*.exists' => 'Informe um registro valido.',
            'nota.between' => 'A nota deve ser de 1 a 5.',
        ];
    }

    private function autorizarAvaliacao(Avaliacao $avaliacao): void
    {
        $empresaId = $this->empresaLogadaId();

        if (!$empresaId) {
            return;
        }

        if (!in_array((int) $empresaId, [
            (int) $avaliacao->empresa_avaliadora_id,
            (int) $avaliacao->empresa_avaliada_id,
        ], true)) {
            abort(403, 'Avaliacao nao pertence a empresa logada.');
        }
    }
}
