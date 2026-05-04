@include('layout.header')

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-fluid">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Resíduos compatíveis</span>
                        <span class="text-muted mt-1 fw-bold fs-7">{{ $interesse->tipo_material }}</span>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-row-bordered align-middle gs-0 gy-3">
                            <thead><tr class="fw-bolder text-muted bg-secondary"><th class="ps-4">Material</th><th>Empresa</th><th>Quantidade</th><th>Local</th><th>Status</th></tr></thead>
                            <tbody>
                                @forelse($residuos as $residuo)
                                    <tr><td class="ps-4">{{ $residuo->tipo_material }}</td><td>{{ optional($residuo->empresa)->nome }}</td><td>{{ $residuo->quantidade }} {{ optional($residuo->unidade)->nome }}</td><td>{{ $residuo->cidade }}/{{ $residuo->estado }}</td><td>{{ $residuo->status }}</td></tr>
                                @empty
                                    <tr><td colspan="5" class="text-center py-8 text-muted">Nenhum resíduo compatível encontrado.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end"><a href="{{ route('interesses.index') }}" class="btn btn-light">Voltar</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout.footer')
@include('painel.shared.alerts')
</body></html>
