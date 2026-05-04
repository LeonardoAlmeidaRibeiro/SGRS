@include('layout.header')

<style>
    .marketplace-detail-image {
        width: 100%;
        max-height: 420px;
        object-fit: cover;
        border-radius: 6px;
        background: #eef1f4;
    }
</style>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-fluid">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">{{ $residuo->tipo_material }}</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Detalhes do resíduo disponível no marketplace</span>
                    </h3>
                </div>

                <div class="card-body">
                    <div class="row g-8">
                        <div class="col-lg-5">
                            <img class="marketplace-detail-image" src="{{ $residuo->imagem ?: url('assets/imagens/SemImagem.png') }}" alt="{{ $residuo->tipo_material }}" onerror="this.onerror=null;this.src='{{ url('assets/imagens/SemImagem.png') }}';">
                        </div>

                        <div class="col-lg-7">
                            <div class="d-flex justify-content-between align-items-start mb-5">
                                <div>
                                    <h2 class="fw-bolder mb-1">{{ $residuo->tipo_material }}</h2>
                                    <div class="text-muted">{{ optional($residuo->empresa)->nome }}</div>
                                    <div class="mt-2">
                                        <span class="badge badge-light-warning">Nota {{ number_format((float) optional($residuo->empresa)->reputacao_media, 1, ',', '.') }}</span>
                                        <span class="badge badge-light-info">Conformidade {{ number_format((float) optional($residuo->empresa)->taxa_conformidade, 0, ',', '.') }}%</span>
                                        @if(optional($residuo->empresa)->restrita_por_reputacao || ((float) optional($residuo->empresa)->reputacao_media > 0 && (float) optional($residuo->empresa)->reputacao_media < 3))
                                            <span class="badge badge-light-danger">Reputacao baixa</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="badge badge-success">Disponível</span>
                            </div>

                            <div class="row mb-6">
                                <div class="col-md-6 mb-5">
                                    <div class="text-muted fw-bold">Classificação</div>
                                    <div class="fs-5">{{ optional($residuo->classificacao)->nome }}</div>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="text-muted fw-bold">Quantidade</div>
                                    <div class="fs-5">{{ $residuo->quantidade }} {{ optional($residuo->unidade)->nome }}</div>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="text-muted fw-bold">Periculosidade</div>
                                    <div class="fs-5">
                                        @if (optional($residuo->classificacao)->exige_mtr || optional($residuo->classificacao)->exige_cadri)
                                            Controlado
                                        @else
                                            Comum
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="text-muted fw-bold">Localização</div>
                                    <div class="fs-5">{{ $residuo->cidade }}/{{ $residuo->estado }}</div>
                                </div>
                                <div class="col-md-12 mb-5">
                                    <div class="text-muted fw-bold">Endereço</div>
                                    <div class="fs-5">{{ $residuo->endereco }}</div>
                                </div>
                                <div class="col-md-12 mb-5">
                                    <div class="text-muted fw-bold">Descrição</div>
                                    <div class="fs-5">{{ $residuo->descricao ?: '-' }}</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('marketplace.index') }}" class="btn btn-light me-2">Voltar</a>
                                @php
                                    $bloqueadoPerigoso = optional($residuo->classificacao)->eh_perigoso && $empresaLogada && !$empresaLogada->podeReceberResiduoPerigoso();
                                @endphp
                                @if($bloqueadoPerigoso)
                                    <button type="button" class="btn btn-light-danger" disabled>Licenca especifica exigida</button>
                                @else
                                    <form method="POST" action="{{ route('marketplace.reservar', $residuo->id) }}" class="form-reservar">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Tenho interesse</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="separator my-10"></div>

                    <h3 class="fw-bolder mb-5">Match inteligente</h3>
                    <div class="table-responsive">
                        <table class="table table-row-bordered align-middle gs-0 gy-3">
                            <thead>
                                <tr class="fw-bolder text-muted bg-secondary">
                                    <th class="ps-4">Empresa interessada</th>
                                    <th>Demanda</th>
                                    <th>Distância</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (($matches ?? collect()) as $match)
                                    <tr>
                                        <td class="ps-4">{{ optional($match->empresa)->nome }}</td>
                                        <td>{{ $match->tipo_material }}</td>
                                        <td>{{ $match->distancia_km !== null ? $match->distancia_km . ' km' : '-' }}</td>
                                        <td><span class="badge badge-success">{{ $match->match_score }}%</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-6 text-muted">Nenhuma empresa com interesse compatível encontrada.</td>
                                    </tr>
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
