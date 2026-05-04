@include('layout.header')

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-fluid">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Detalhes da Transacao</span>
                        <span class="text-muted mt-1 fw-bold fs-7">{{ $transacao->codigo_rastreio ?: 'Sem codigo de rastreio' }}</span>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-6"><div class="text-muted fw-bold">Residuo</div><div class="fs-5">{{ optional($transacao->residuo)->tipo_material }}</div></div>
                        <div class="col-md-4 mb-6"><div class="text-muted fw-bold">Origem</div><div class="fs-5">{{ optional($transacao->empresaOrigem)->nome }}</div></div>
                        <div class="col-md-4 mb-6"><div class="text-muted fw-bold">Destino</div><div class="fs-5">{{ optional($transacao->empresaDestino)->nome }}</div></div>
                        <div class="col-md-3 mb-6"><div class="text-muted fw-bold">Transportadora</div><div class="fs-5">{{ optional($transacao->empresaTransportadora)->nome ?: '-' }}</div></div>
                        <div class="col-md-3 mb-6"><div class="text-muted fw-bold">Status</div><div class="fs-5">{{ ucfirst($transacao->status) }}</div></div>
                        <div class="col-md-3 mb-6"><div class="text-muted fw-bold">Data transacao</div><div class="fs-5">{{ optional($transacao->data_transacao)->format('d/m/Y') ?: '-' }}</div></div>
                        <div class="col-md-3 mb-6"><div class="text-muted fw-bold">Recebimento</div><div class="fs-5">{{ optional($transacao->data_recebimento)->format('d/m/Y H:i') ?: '-' }}</div></div>
                    </div>

                    <div class="separator my-8"></div>
                    <h4 class="fw-bolder mb-5">Documentos</h4>
                    <div class="table-responsive mb-8">
                        <table class="table table-row-bordered align-middle gs-0 gy-3">
                            <thead><tr class="fw-bolder text-muted bg-secondary"><th class="ps-4">Tipo</th><th>Numero</th><th>Status</th><th>Validade</th><th>Arquivo</th></tr></thead>
                            <tbody>
                                @forelse($transacao->documentos as $documento)
                                    <tr>
                                        <td class="ps-4">{{ $documento->tipo_documento }}</td>
                                        <td>{{ $documento->numero_documento ?: '-' }}</td>
                                        <td><span class="badge badge-light-{{ $documento->status_validacao === 'valido' ? 'success' : ($documento->status_validacao === 'rejeitado' ? 'danger' : 'warning') }}">{{ ucfirst($documento->status_validacao) }}</span></td>
                                        <td>{{ optional($documento->data_validade)->format('d/m/Y') ?: '-' }}</td>
                                        <td>@if($documento->arquivo_url)<a href="{{ $documento->arquivo_url }}" target="_blank">Abrir</a>@else - @endif</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center py-6 text-muted">Nenhum documento cadastrado.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h4 class="fw-bolder mb-5">Impacto</h4>
                    <div class="row mb-8">
                        <div class="col-md-3 mb-6"><div class="text-muted fw-bold">CO2 economizado</div><div class="fs-5">{{ optional($transacao->impacto)->co2_economizado ?: 0 }}</div></div>
                        <div class="col-md-3 mb-6"><div class="text-muted fw-bold">Agua economizada</div><div class="fs-5">{{ optional($transacao->impacto)->agua_economizada ?: 0 }}</div></div>
                        <div class="col-md-3 mb-6"><div class="text-muted fw-bold">Energia economizada</div><div class="fs-5">{{ optional($transacao->impacto)->energia_economizada ?: 0 }}</div></div>
                        <div class="col-md-3 mb-6"><div class="text-muted fw-bold">Valor economizado</div><div class="fs-5">R$ {{ optional($transacao->impacto)->valor_economizado ?: 0 }}</div></div>
                    </div>

                    <h4 class="fw-bolder mb-5">Linha do tempo de rastreabilidade</h4>
                    <div class="timeline">
                        @forelse($transacao->logsRastreabilidade->sortBy('created_at') as $log)
                            <div class="timeline-item mb-6">
                                <div class="timeline-line w-40px"></div>
                                <div class="timeline-icon symbol symbol-circle symbol-40px me-4"><span class="symbol-label bg-light-primary"><i class="las la-fingerprint fs-2 text-primary"></i></span></div>
                                <div class="timeline-content">
                                    <div class="fw-bolder">{{ ucfirst(str_replace('_', ' ', $log->acao)) }}</div>
                                    <div class="text-muted fs-7">{{ optional($log->created_at)->format('d/m/Y H:i') }} - {{ optional($log->empresa)->nome ?: 'Sistema' }}</div>
                                    <div>{{ $log->descricao }}</div>
                                    <div class="fs-8 text-muted">Hash: {{ $log->hash_evento }}</div>
                                    @if($log->documento_url)<a href="{{ $log->documento_url }}" target="_blank" class="fs-7">Documento vinculado</a>@endif
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">Nenhum evento de rastreabilidade registrado.</div>
                        @endforelse
                    </div>

                    <div class="text-end"><a href="{{ route('transacoes.index') }}" class="btn btn-light">Voltar</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout.footer')
@include('painel.shared.alerts')
</body>
</html>
