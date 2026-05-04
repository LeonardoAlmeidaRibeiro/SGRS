<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Residuo;
use App\Models\Transacao;
use App\Services\ImpactoCalculatorService;
use App\Services\RastreabilidadeService;
use App\Services\ValidacaoLegalService;
use App\Support\EmpresaScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransacaoController extends Controller
{
    use EmpresaScope;

    public function index()
    {
        $query = Transacao::with(['residuo', 'empresaOrigem', 'empresaDestino']);
        $this->escopoTransacaoEmpresa($query);
        $transacoes = $query->latest()->paginate(15);

        return view('painel.transacoes.index', compact('transacoes'));
    }

    public function create()
    {
        return view('painel.transacoes.form', $this->options());
    }

    public function store(Request $request, ImpactoCalculatorService $impactoService, RastreabilidadeService $rastreabilidadeService, ValidacaoLegalService $validacaoLegalService)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dados = $this->data($validator->validated(), $rastreabilidadeService);
        $bloqueio = $this->validarTransferencia($dados);
        if ($bloqueio) {
            return back()->withInput()->with('swal_error', $bloqueio);
        }

        $transacao = Transacao::create($dados);
        $bloqueioStatus = $validacaoLegalService->validarTransacaoParaStatus($transacao, $transacao->status);
        if ($bloqueioStatus) {
            $transacao->delete();
            return back()->withInput()->with('swal_error', $bloqueioStatus);
        }
        $this->sincronizarResiduo($transacao);
        $this->calcularImpacto($transacao, $impactoService);
        $rastreabilidadeService->registrar($transacao, 'transacao_criada', 'Transacao criada manualmente no painel.');

        return redirect()->route('transacoes.index')->with('swal_success', 'Transação cadastrada com sucesso!');
    }

    public function show(Transacao $transacao)
    {
        $this->autorizarTransacao($transacao);

        $transacao->load(['residuo.unidade', 'empresaOrigem', 'empresaDestino', 'empresaTransportadora', 'documentos', 'impacto', 'avaliacoes', 'logsRastreabilidade.empresa', 'logsRastreabilidade.usuario']);

        return view('painel.transacoes.visualizar', compact('transacao'));
    }

    public function edit(Transacao $transacao)
    {
        $this->autorizarTransacao($transacao);

        return view('painel.transacoes.form', array_merge($this->options(), compact('transacao')));
    }

    public function update(Request $request, Transacao $transacao, ImpactoCalculatorService $impactoService, RastreabilidadeService $rastreabilidadeService, ValidacaoLegalService $validacaoLegalService)
    {
        $this->autorizarTransacao($transacao);

        $validator = Validator::make($request->all(), $this->rules(), $this->messages());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $dados = $this->data($validator->validated(), $rastreabilidadeService, $transacao);
        $bloqueio = $this->validarTransferencia($dados);
        if ($bloqueio) {
            return back()->withInput()->with('swal_error', $bloqueio);
        }

        $snapshot = $transacao->getAttributes();
        $transacao->fill($dados);
        $bloqueioStatus = $validacaoLegalService->validarTransacaoParaStatus($transacao, $transacao->status);
        if ($bloqueioStatus) {
            $transacao->setRawAttributes($snapshot, true);
            return back()->withInput()->with('swal_error', $bloqueioStatus);
        }

        $transacao->save();
        $this->sincronizarResiduo($transacao);
        $this->calcularImpacto($transacao, $impactoService);
        $rastreabilidadeService->registrar($transacao, 'transacao_atualizada', 'Transacao atualizada no painel.');

        return redirect()->route('transacoes.index')->with('swal_success', 'Transação atualizada com sucesso!');
    }

    public function destroy(Transacao $transacao)
    {
        $this->autorizarTransacao($transacao);

        $transacao->delete();

        return redirect()->route('transacoes.index')->with('swal_success', 'Transação excluída com sucesso!');
    }

    private function options(): array
    {
        return [
            'residuos' => Residuo::with('empresa')
                ->when($this->empresaLogadaId(), function ($q) {
                    $q->where('empresa_id', $this->empresaLogadaId());
                })
                ->orderBy('tipo_material')
                ->get(),
            'empresas' => $this->empresasRelacionadas(),
            'statusOptions' => ['pendente' => 'Pendente', 'aprovado' => 'Aprovado', 'concluido' => 'Concluído', 'cancelado' => 'Cancelado'],
        ];
    }

    private function rules(): array
    {
        return [
            'residuo_id' => ['required', 'exists:residuos,id'],
            'empresa_origem_id' => ['required', 'exists:empresas,id'],
            'empresa_destino_id' => ['required', 'exists:empresas,id'],
            'empresa_transportadora_id' => ['nullable', 'exists:empresas,id'],
            'status' => ['required', 'in:pendente,aprovado,concluido,cancelado'],
            'data_transacao' => ['nullable', 'date'],
            'data_recebimento' => ['nullable', 'date'],
        ];
    }

    private function data(array $validated, RastreabilidadeService $rastreabilidadeService, ?Transacao $transacao = null): array
    {
        if ($transacao && $transacao->codigo_rastreio) {
            $validated['codigo_rastreio'] = $transacao->codigo_rastreio;
            $validated['hash_rastreio'] = $transacao->hash_rastreio;
            return $validated;
        }

        return $rastreabilidadeService->prepararTransacao($validated);
    }

    private function validarTransferencia(array $dados): ?string
    {
        $residuo = Residuo::with('classificacao')->find($dados['residuo_id']);
        $empresaDestino = Empresa::find($dados['empresa_destino_id']);

        if (!$residuo || !$empresaDestino) {
            return 'Informe residuo e empresa destino validos.';
        }

        if ($this->empresaLogadaId() && !in_array((int) $this->empresaLogadaId(), [
            (int) $dados['empresa_origem_id'],
            (int) $dados['empresa_destino_id'],
            (int) ($dados['empresa_transportadora_id'] ?? 0),
        ], true)) {
            return 'A transacao precisa pertencer a empresa logada.';
        }

        if (optional($residuo->classificacao)->eh_perigoso && !$empresaDestino->podeReceberResiduoPerigoso()) {
            return 'Residuo perigoso so pode ser transferido para empresa com licenca ambiental especifica valida.';
        }

        if ($empresaDestino->restrita_por_reputacao || ((float) $empresaDestino->reputacao_media > 0 && (float) $empresaDestino->reputacao_media < 3)) {
            return 'Empresa destino esta restrita por reputacao baixa.';
        }

        return null;
    }

    private function autorizarTransacao(Transacao $transacao): void
    {
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

    private function empresasRelacionadas()
    {
        if (!$this->empresaLogadaId()) {
            return Empresa::orderBy('nome')->get();
        }

        $transacoes = $this->escopoTransacaoEmpresa(Transacao::query())->get(['empresa_origem_id', 'empresa_destino_id', 'empresa_transportadora_id']);
        $ids = $transacoes->pluck('empresa_origem_id')
            ->merge($transacoes->pluck('empresa_destino_id'))
            ->merge($transacoes->pluck('empresa_transportadora_id'))
            ->push($this->empresaLogadaId())
            ->filter()
            ->unique()
            ->values();

        return Empresa::whereIn('id', $ids)->orderBy('nome')->get();
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
