@include('layout.header')

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-fluid">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Detalhes do Resíduo</span>
                        <span class="text-muted mt-1 fw-bold fs-7">{{ $residuo->tipo_material }}</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{ route('residuos.edit', $residuo->id) }}" class="btn btn-sm btn-light-primary">Editar</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-6">
                            <div class="text-muted fw-bold">Empresa</div>
                            <div class="fs-5">{{ optional($residuo->empresa)->nome }}</div>
                        </div>
                        <div class="col-md-6 mb-6">
                            <div class="text-muted fw-bold">Classificação</div>
                            <div class="fs-5">{{ optional($residuo->classificacao)->nome }}</div>
                        </div>
                        <div class="col-md-4 mb-6">
                            <div class="text-muted fw-bold">Quantidade</div>
                            <div class="fs-5">{{ $residuo->quantidade }} {{ optional($residuo->unidade)->nome }}</div>
                        </div>
                        <div class="col-md-4 mb-6">
                            <div class="text-muted fw-bold">Status</div>
                            <div class="fs-5">{{ ucfirst($residuo->status) }}</div>
                        </div>
                        <div class="col-md-4 mb-6">
                            <div class="text-muted fw-bold">Quantidade em KG</div>
                            <div class="fs-5">{{ $residuo->quantidade_em_kg }}</div>
                        </div>
                        <div class="col-md-12 mb-6">
                            <div class="text-muted fw-bold">Descrição</div>
                            <div class="fs-5">{{ $residuo->descricao ?: '-' }}</div>
                        </div>
                        <div class="col-md-6 mb-6">
                            <div class="text-muted fw-bold">Endereço</div>
                            <div class="fs-5">{{ $residuo->endereco }}</div>
                        </div>
                        <div class="col-md-3 mb-6">
                            <div class="text-muted fw-bold">Cidade</div>
                            <div class="fs-5">{{ $residuo->cidade }}</div>
                        </div>
                        <div class="col-md-3 mb-6">
                            <div class="text-muted fw-bold">Estado</div>
                            <div class="fs-5">{{ $residuo->estado }}</div>
                        </div>
                        <div class="col-md-6 mb-6">
                            <div class="text-muted fw-bold">Latitude</div>
                            <div class="fs-5">{{ $residuo->latitude ?: '-' }}</div>
                        </div>
                        <div class="col-md-6 mb-6">
                            <div class="text-muted fw-bold">Longitude</div>
                            <div class="fs-5">{{ $residuo->longitude ?: '-' }}</div>
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('residuos.index') }}" class="btn btn-light">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout.footer')
@include('painel.residuos._alerts')

</body>
</html>
