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
                                <form method="POST" action="{{ route('marketplace.reservar', $residuo->id) }}" class="form-reservar">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Tenho interesse</button>
                                </form>
                            </div>
                        </div>
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
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>

@include('painel.marketplace._alerts')

</body>
</html>
