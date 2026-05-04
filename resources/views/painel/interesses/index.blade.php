@include('layout.header')

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-fluid">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Interesses</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Demandas das empresas para match inteligente</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{ route('interesses.create') }}" class="btn btn-sm btn-light-primary">Novo Interesse</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-row-bordered align-middle gs-0 gy-3">
                            <thead>
                                <tr class="fw-bolder text-muted bg-secondary">
                                    <th class="ps-4 rounded-start">Empresa</th>
                                    <th>Material</th>
                                    <th>Classificação</th>
                                    <th>Quantidade</th>
                                    <th>Raio</th>
                                    <th class="text-end rounded-end pe-4">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($interesses as $interesse)
                                    <tr>
                                        <td class="ps-4">{{ optional($interesse->empresa)->nome }}</td>
                                        <td>{{ $interesse->tipo_material }}</td>
                                        <td>{{ optional($interesse->classificacao)->nome }}</td>
                                        <td>{{ $interesse->quantidade_minima ?: '0' }} até {{ $interesse->quantidade_maxima ?: 'sem limite' }}</td>
                                        <td>{{ $interesse->raio_km ? $interesse->raio_km . ' km' : '-' }}</td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('interesses.show', $interesse->id) }}" class="btn btn-sm btn-light-info">Matches</a>
                                            <a href="{{ route('interesses.edit', $interesse->id) }}" class="btn btn-sm btn-light-primary">Editar</a>
                                            <form method="POST" action="{{ route('interesses.destroy', $interesse->id) }}" class="d-inline form-excluir">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light-danger">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center py-8 text-muted">Nenhum interesse cadastrado.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $interesses->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout.footer')
<script>
    $('.form-excluir').on('submit', function (event) {
        event.preventDefault();
        var form = this;
        Swal.fire({ title: 'Excluir interesse?', text: 'Essa ação não poderá ser desfeita.', icon: 'warning', showCancelButton: true, cancelButtonText: 'Cancelar', confirmButtonText: 'Sim, excluir' }).then(function (result) {
            if (result.isConfirmed) form.submit();
        });
    });
</script>
@include('painel.shared.alerts')
</body></html>
