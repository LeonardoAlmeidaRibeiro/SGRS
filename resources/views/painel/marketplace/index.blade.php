@include('layout.header')

<style>
    .marketplace-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 6px 6px 0 0;
        background: #eef1f4;
    }

    .marketplace-card {
        height: 100%;
    }
</style>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-fluid">

            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Marketplace</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Resíduos disponíveis para negociação entre empresas</span>
                    </h3>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('marketplace.index') }}" class="mb-8">
                        <div class="row">
                            <div class="col-md-3 mb-4">
                                <label class="fs-7 fw-bold text-muted mb-1">Tipo de material</label>
                                <input type="text" class="form-control form-control-solid" name="tipo_material" value="{{ request('tipo_material') }}" placeholder="Plástico, metal, vidro...">
                            </div>

                            <div class="col-md-3 mb-4">
                                <label class="fs-7 fw-bold text-muted mb-1">Classificação</label>
                                <select class="form-select form-select-solid" name="classificacao_id">
                                    <option value="">Todas</option>
                                    @foreach ($classificacoes as $classificacao)
                                        <option value="{{ $classificacao->id }}" @selected((string) request('classificacao_id') === (string) $classificacao->id)>
                                            {{ $classificacao->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 mb-4">
                                <label class="fs-7 fw-bold text-muted mb-1">Periculosidade</label>
                                <select class="form-select form-select-solid" name="periculosidade">
                                    <option value="">Todas</option>
                                    <option value="controlado" @selected(request('periculosidade') === 'controlado')>Controlado</option>
                                    <option value="comum" @selected(request('periculosidade') === 'comum')>Comum</option>
                                </select>
                            </div>

                            <div class="col-md-2 mb-4">
                                <label class="fs-7 fw-bold text-muted mb-1">Qtd. mínima</label>
                                <input type="number" class="form-control form-control-solid" name="quantidade_min" step="0.001" min="0" value="{{ request('quantidade_min') }}">
                            </div>

                            <div class="col-md-2 mb-4">
                                <label class="fs-7 fw-bold text-muted mb-1">Qtd. máxima</label>
                                <input type="number" class="form-control form-control-solid" name="quantidade_max" step="0.001" min="0" value="{{ request('quantidade_max') }}">
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="fs-7 fw-bold text-muted mb-1">Cidade</label>
                                <input type="text" class="form-control form-control-solid" name="cidade" value="{{ request('cidade') }}" placeholder="Cidade">
                            </div>

                            <div class="col-md-2 mb-4">
                                <label class="fs-7 fw-bold text-muted mb-1">UF</label>
                                <input type="text" class="form-control form-control-solid text-uppercase" name="estado" maxlength="2" value="{{ request('estado') }}" placeholder="SP">
                            </div>

                            <div class="col-md-3 mb-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">Filtrar</button>
                                <a href="{{ route('marketplace.index') }}" class="btn btn-light">Limpar</a>
                            </div>
                        </div>
                    </form>

                    <div class="row g-5">
                        @forelse ($residuos as $residuo)
                            <div class="col-md-6 col-xl-4">
                                <div class="card marketplace-card">
                                    <img class="marketplace-image" src="{{ $residuo->imagem ?: url('assets/imagens/SemImagem.png') }}" alt="{{ $residuo->tipo_material }}" onerror="this.onerror=null;this.src='{{ url('assets/imagens/SemImagem.png') }}';">

                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h4 class="fw-bolder mb-1">{{ $residuo->tipo_material }}</h4>
                                                <div class="text-muted fs-7">{{ optional($residuo->empresa)->nome }}</div>
                                            </div>
                                            <span class="badge badge-success">Disponível</span>
                                        </div>

                                        <div class="mb-4 text-muted">{{ \Illuminate\Support\Str::limit($residuo->descricao, 105) }}</div>

                                        <div class="mb-4">
                                            <div class="fw-bold">{{ $residuo->quantidade }} {{ optional($residuo->unidade)->nome }}</div>
                                            <div class="text-muted fs-7">{{ optional($residuo->classificacao)->nome }}</div>
                                            <div class="text-muted fs-7">{{ $residuo->cidade }}/{{ $residuo->estado }}</div>
                                        </div>

                                        <div class="mt-auto d-flex justify-content-end">
                                            <a href="{{ route('marketplace.show', $residuo->id) }}" class="btn btn-sm btn-light-info me-2">Ver detalhes</a>

                                            <form method="POST" action="{{ route('marketplace.reservar', $residuo->id) }}" class="form-reservar">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary">Tenho interesse</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">Nenhum resíduo disponível foi encontrado com os filtros informados.</div>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $residuos->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('layout.footer')

<script>
    $('.form-reservar').on('submit', function (event) {
        event.preventDefault();

        var form = this;

        Swal.fire({
            title: 'Confirmar interesse?',
            text: 'O resíduo será marcado como reservado para continuidade da negociação.',
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sim, reservar',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then(function (result) {
            if (result.isConfirmed || result.value) {
                form.submit();
            }
        });
    });
</script>

@include('painel.marketplace._alerts')

</body>
</html>
