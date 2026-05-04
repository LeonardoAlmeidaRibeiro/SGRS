@include('layout.header')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<style>
    .marketplace-detail-image {
        width: 100%;
        max-height: 420px;
        object-fit: cover;
        border-radius: 6px;
        background: #eef1f4;
    }

    .marketplace-map {
        width: 100%;
        height: 320px;
        border-radius: 6px;
        border: 1px solid #e4e6ef;
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

                    <div class="row g-6 mb-10">
                        <div class="col-lg-8">
                            <h3 class="fw-bolder mb-4">Localizacao do residuo</h3>
                            @if($residuo->latitude && $residuo->longitude)
                                <div id="residuo-map" class="marketplace-map"></div>
                            @else
                                <div class="alert alert-warning mb-0">Este residuo ainda nao possui latitude e longitude cadastradas.</div>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-light h-100">
                                <div class="card-body">
                                    <div class="text-muted fw-bold mb-2">Distancia ate voce</div>
                                    <div id="distancia-atual" class="fs-3 fw-bolder">Aguardando localizacao</div>
                                    <div class="text-muted fs-7 mt-3">Permita o acesso a sua localizacao no navegador para calcular a distancia aproximada ate o residuo.</div>
                                    <div class="separator my-5"></div>
                                    <div class="text-muted fw-bold">Coordenadas do residuo</div>
                                    <div class="fs-6">{{ $residuo->latitude ?: '-' }}, {{ $residuo->longitude ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

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

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    (function () {
        var residuoLat = @json($residuo->latitude ? (float) $residuo->latitude : null);
        var residuoLng = @json($residuo->longitude ? (float) $residuo->longitude : null);
        var distanciaEl = document.getElementById('distancia-atual');

        if (!residuoLat || !residuoLng || !document.getElementById('residuo-map') || typeof L === 'undefined') {
            if (distanciaEl) {
                distanciaEl.textContent = 'Indisponivel';
            }
            return;
        }

        var map = L.map('residuo-map').setView([residuoLat, residuoLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        L.marker([residuoLat, residuoLng]).addTo(map)
            .bindPopup(@json($residuo->tipo_material . ' - ' . $residuo->cidade . '/' . $residuo->estado))
            .openPopup();

        function distanciaKm(lat1, lon1, lat2, lon2) {
            var raioTerra = 6371;
            var dLat = (lat2 - lat1) * Math.PI / 180;
            var dLon = (lon2 - lon1) * Math.PI / 180;
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2)
                + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180)
                * Math.sin(dLon / 2) * Math.sin(dLon / 2);

            return raioTerra * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)));
        }

        if (!navigator.geolocation) {
            distanciaEl.textContent = 'Localizacao nao suportada';
            return;
        }

        navigator.geolocation.getCurrentPosition(function (position) {
            var userLat = position.coords.latitude;
            var userLng = position.coords.longitude;
            var distancia = distanciaKm(userLat, userLng, residuoLat, residuoLng);

            distanciaEl.textContent = distancia.toLocaleString('pt-BR', {
                maximumFractionDigits: 1
            }) + ' km';

            L.marker([userLat, userLng]).addTo(map).bindPopup('Voce esta aqui');
            L.polyline([[userLat, userLng], [residuoLat, residuoLng]], {
                color: '#1f6f43',
                weight: 3
            }).addTo(map);
            map.fitBounds([[userLat, userLng], [residuoLat, residuoLng]], { padding: [28, 28] });
        }, function () {
            distanciaEl.textContent = 'Permissao negada';
        }, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 60000
        });
    })();

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
