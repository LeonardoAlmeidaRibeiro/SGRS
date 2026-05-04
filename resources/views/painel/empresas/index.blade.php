@include('layout.header')

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-fluid">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Empresas</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Cadastro, licencas e funcionarios vinculados</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{ route('empresas.create') }}" class="btn btn-sm btn-light-primary">Nova empresa</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-row-bordered align-middle gs-0 gy-3">
                            <thead>
                                <tr class="fw-bolder text-muted bg-secondary">
                                    <th class="ps-4">Empresa</th>
                                    <th>Localizacao</th>
                                    <th>Licenca</th>
                                    <th>Reputacao</th>
                                    <th>Funcionarios</th>
                                    <th class="text-end pe-4">Acoes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($empresas as $empresa)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bolder">{{ $empresa->nome }}</div>
                                            <div class="text-muted fs-7">{{ $empresa->cnpj }}</div>
                                        </td>
                                        <td>{{ $empresa->cidade }}/{{ $empresa->estado }}</td>
                                        <td>
                                            @if($empresa->podeReceberResiduoPerigoso())
                                                <span class="badge badge-success">Perigosos autorizado</span>
                                            @elseif($empresa->possui_licenca_ambiental)
                                                <span class="badge badge-light-info">Licenca comum</span>
                                            @else
                                                <span class="badge badge-light-danger">Sem licenca</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-light-warning">Nota {{ number_format((float) $empresa->reputacao_media, 1, ',', '.') }}</span>
                                            <span class="badge badge-light-info">{{ number_format((float) $empresa->taxa_conformidade, 0, ',', '.') }}%</span>
                                        </td>
                                        <td>{{ $empresa->usuarios_count }}</td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('empresas.show', $empresa->id) }}" class="btn btn-sm btn-light-info">Ver</a>
                                            <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn btn-sm btn-light-primary">Editar</a>
                                            <form method="POST" action="{{ route('empresas.destroy', $empresa->id) }}" class="d-inline form-excluir">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-light-danger">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center py-8 text-muted">Nenhuma empresa cadastrada.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $empresas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout.footer')
<script>
$('.form-excluir').on('submit', function(e) {
    e.preventDefault();
    var form = this;
    Swal.fire({ title: 'Excluir empresa?', icon: 'warning', showCancelButton: true, cancelButtonText: 'Cancelar', confirmButtonText: 'Sim, excluir' }).then(function(r) {
        if (r.isConfirmed || r.value) form.submit();
    });
});
</script>
@include('painel.shared.alerts')
</body>
</html>
