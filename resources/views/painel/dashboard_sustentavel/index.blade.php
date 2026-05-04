@include('layout.header')

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-fluid">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Dashboard Sustentável</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Indicadores de reaproveitamento e impacto ambiental</span>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-5 mb-8">
                        @foreach([
                            'Resíduos disponíveis' => $indicadores['residuos_disponiveis'],
                            'Transações concluídas' => $indicadores['transacoes_concluidas'],
                            'Quantidade reaproveitada' => number_format($indicadores['quantidade_reaproveitada'], 3, ',', '.'),
                            'CO₂ economizado' => number_format($indicadores['co2_economizado'], 3, ',', '.'),
                            'Água economizada' => number_format($indicadores['agua_economizada'], 3, ',', '.'),
                            'Energia economizada' => number_format($indicadores['energia_economizada'], 3, ',', '.'),
                            'Valor economizado' => 'R$ ' . number_format($indicadores['valor_economizado'], 2, ',', '.'),
                            'Nota média' => $indicadores['nota_media'] ?: '-',
                        ] as $label => $valor)
                            <div class="col-md-3">
                                <div class="border rounded p-5 h-100">
                                    <div class="text-muted fw-bold fs-7">{{ $label }}</div>
                                    <div class="fw-bolder fs-2 mt-2">{{ $valor }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row g-5">
                        <div class="col-md-6">
                            <h4 class="fw-bolder mb-4">Transações por status</h4>
                            <table class="table table-row-bordered">
                                <tbody>
                                    @foreach(['pendente' => 'Pendente', 'aprovado' => 'Aprovado', 'concluido' => 'Concluído', 'cancelado' => 'Cancelado'] as $status => $label)
                                        <tr><td>{{ $label }}</td><td class="text-end fw-bold">{{ $porStatus[$status] ?? 0 }}</td></tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4 class="fw-bolder mb-4">Quantidade por material</h4>
                            <table class="table table-row-bordered">
                                <tbody>
                                    @forelse($porMaterial as $item)
                                        <tr><td>{{ $item->tipo_material }}</td><td class="text-end fw-bold">{{ number_format($item->total, 3, ',', '.') }}</td></tr>
                                    @empty
                                        <tr><td class="text-muted">Sem dados para exibir.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout.footer')
@include('painel.shared.alerts')
</body></html>
