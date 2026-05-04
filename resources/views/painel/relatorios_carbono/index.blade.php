@include('layout.header')

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-fluid">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Relatório de Carbono</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Cálculo gerado pelo serviço Laravel quando o Python não estiver disponível</span>
                    </h3>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('relatorio-carbono.index') }}" class="mb-8">
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <label class="fs-7 fw-bold text-muted mb-1">Status</label>
                                <select name="status" class="form-select form-select-solid">
                                    <option value="">Todos</option>
                                    <option value="pendente" @selected(request('status') === 'pendente')>Pendente</option>
                                    <option value="aprovado" @selected(request('status') === 'aprovado')>Aprovado</option>
                                    <option value="concluido" @selected(request('status') === 'concluido')>Concluído</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="fs-7 fw-bold text-muted mb-1">Data início</label>
                                <input type="date" name="data_inicio" class="form-control form-control-solid" value="{{ request('data_inicio') }}">
                            </div>
                            <div class="col-md-3 mb-4">
                                <label class="fs-7 fw-bold text-muted mb-1">Data fim</label>
                                <input type="date" name="data_fim" class="form-control form-control-solid" value="{{ request('data_fim') }}">
                            </div>
                            <div class="col-md-3 mb-4 d-flex align-items-end">
                                <button class="btn btn-primary me-2">Filtrar</button>
                                <a href="{{ route('relatorio-carbono.index') }}" class="btn btn-light">Limpar</a>
                            </div>
                        </div>
                    </form>

                    <div class="row g-5 mb-8">
                        <div class="col-md-3"><div class="border rounded p-5"><div class="text-muted fw-bold">CO₂ economizado</div><div class="fs-2 fw-bolder">{{ number_format($totais['co2_economizado'], 3, ',', '.') }}</div></div></div>
                        <div class="col-md-3"><div class="border rounded p-5"><div class="text-muted fw-bold">Água economizada</div><div class="fs-2 fw-bolder">{{ number_format($totais['agua_economizada'], 3, ',', '.') }}</div></div></div>
                        <div class="col-md-3"><div class="border rounded p-5"><div class="text-muted fw-bold">Energia economizada</div><div class="fs-2 fw-bolder">{{ number_format($totais['energia_economizada'], 3, ',', '.') }}</div></div></div>
                        <div class="col-md-3"><div class="border rounded p-5"><div class="text-muted fw-bold">Valor economizado</div><div class="fs-2 fw-bolder">R$ {{ number_format($totais['valor_economizado'], 2, ',', '.') }}</div></div></div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-row-bordered align-middle gs-0 gy-3">
                            <thead>
                                <tr class="fw-bolder text-muted bg-secondary">
                                    <th class="ps-4">Transação</th>
                                    <th>Material</th>
                                    <th>Quantidade</th>
                                    <th>Origem</th>
                                    <th>Destino</th>
                                    <th>CO₂</th>
                                    <th>Água</th>
                                    <th>Energia</th>
                                    <th class="text-end pe-4">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($linhas as $linha)
                                    <tr>
                                        <td class="ps-4">#{{ $linha['transacao']->id }}</td>
                                        <td>{{ $linha['tipo_material'] }}</td>
                                        <td>{{ $linha['quantidade'] }} {{ $linha['unidade'] }}</td>
                                        <td>{{ optional($linha['transacao']->empresaOrigem)->nome }}</td>
                                        <td>{{ optional($linha['transacao']->empresaDestino)->nome }}</td>
                                        <td>{{ number_format($linha['impacto']['co2_economizado'], 3, ',', '.') }}</td>
                                        <td>{{ number_format($linha['impacto']['agua_economizada'], 3, ',', '.') }}</td>
                                        <td>{{ number_format($linha['impacto']['energia_economizada'], 3, ',', '.') }}</td>
                                        <td class="text-end pe-4">R$ {{ number_format($linha['impacto']['valor_economizado'], 2, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="9" class="text-center py-8 text-muted">Nenhuma transação encontrada para o relatório.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout.footer')
@include('painel.shared.alerts')
</body></html>
