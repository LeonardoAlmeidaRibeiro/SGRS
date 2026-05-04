@include('layout.header')

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-fluid">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Resíduos</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Controle de resíduos cadastrados</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{ route('residuos.create') }}" class="btn btn-sm btn-light-primary">Novo Resíduo</a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('residuos.index') }}" class="mb-8">
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <input type="text" class="form-control form-control-solid" name="tipo_material" placeholder="Tipo de material" value="{{ request('tipo_material') }}">
                            </div>
                            <div class="col-md-3 mb-4">
                                <select class="form-select form-select-solid" name="classificacao_id">
                                    <option value="">Classificação</option>
                                    @foreach ($classificacoes as $classificacao)
                                        <option value="{{ $classificacao->id }}" @selected((string) request('classificacao_id') === (string) $classificacao->id)>
                                            {{ $classificacao->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-4">
                                <select class="form-select form-select-solid" name="status">
                                    <option value="">Status</option>
                                    <option value="disponivel" @selected(request('status') === 'disponivel')>Disponível</option>
                                    <option value="reservado" @selected(request('status') === 'reservado')>Reservado</option>
                                    <option value="finalizado" @selected(request('status') === 'finalizado')>Finalizado</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-4">
                                <input type="text" class="form-control form-control-solid" name="cidade" placeholder="Cidade" value="{{ request('cidade') }}">
                            </div>
                            <div class="col-md-1 mb-4">
                                <input type="text" class="form-control form-control-solid text-uppercase" name="estado" maxlength="2" placeholder="UF" value="{{ request('estado') }}">
                            </div>
                            <div class="col-md-1 mb-4">
                                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                            <thead>
                                <tr class="fw-bolder text-muted bg-secondary">
                                    <th class="ps-4 rounded-start">Material</th>
                                    <th>Empresa</th>
                                    <th>Classificação</th>
                                    <th>Quantidade</th>
                                    <th>Status</th>
                                    <th>Local</th>
                                    <th class="text-end rounded-end pe-4">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($residuos as $residuo)
                                    <tr>
                                        <td class="ps-4 fw-bolder">{{ $residuo->tipo_material }}</td>
                                        <td>{{ optional($residuo->empresa)->nome }}</td>
                                        <td>{{ optional($residuo->classificacao)->nome }}</td>
                                        <td>{{ $residuo->quantidade }} {{ optional($residuo->unidade)->nome }}</td>
                                        <td>
                                            @if ($residuo->status === 'disponivel')
                                                <span class="badge badge-success">Disponível</span>
                                            @elseif ($residuo->status === 'reservado')
                                                <span class="badge badge-warning">Reservado</span>
                                            @else
                                                <span class="badge badge-secondary">Finalizado</span>
                                            @endif
                                        </td>
                                        <td>{{ $residuo->cidade }}/{{ $residuo->estado }}</td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('residuos.show', $residuo->id) }}" class="btn btn-sm btn-light-info">Ver</a>
                                            <a href="{{ route('residuos.edit', $residuo->id) }}" class="btn btn-sm btn-light-primary">Editar</a>
                                            <form method="POST" action="{{ route('residuos.destroy', $residuo->id) }}" class="d-inline form-excluir">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light-danger">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-10 text-muted">Nenhum resíduo encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $residuos->links() }}
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

        Swal.fire({
            title: 'Tem certeza que deseja excluir?',
            text: 'Não será possível reverter essa ação.',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sim, excluir!',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then(function (result) {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>

@include('painel.residuos._alerts')

</body>
</html>
