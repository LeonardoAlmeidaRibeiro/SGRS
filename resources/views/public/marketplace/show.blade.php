<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $residuo->tipo_material }} | SGRS Marketplace</title>
    <link rel="shortcut icon" href="{{ url('assets/imagens/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700">
    <link href="{{ url('assets/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Poppins, Arial, sans-serif; color: #17212b; background: #f4f7f5; }
        a { color: inherit; text-decoration: none; }
        .topbar { background: #fff; border-bottom: 1px solid #dde6df; }
        .topbar-inner, .wrap { max-width: 1120px; margin: 0 auto; padding: 16px 22px; }
        .topbar-inner { display: flex; justify-content: space-between; align-items: center; gap: 16px; }
        .brand { font-weight: 700; color: #123322; }
        .btn { display: inline-flex; align-items: center; justify-content: center; min-height: 40px; padding: 0 16px; border-radius: 6px; border: 1px solid #1f6f43; font-weight: 600; font-size: 13px; }
        button.btn { font-family: inherit; cursor: pointer; }
        .btn-primary { background: #1f6f43; color: #fff; }
        .btn-light { background: #fff; color: #1f6f43; }
        .detail { display: grid; grid-template-columns: 1.1fr .9fr; gap: 28px; padding-top: 34px; }
        .photo { width: 100%; min-height: 420px; object-fit: cover; border-radius: 8px; background: #e8eeea; }
        .panel { background: #fff; border: 1px solid #dde6df; border-radius: 8px; padding: 24px; }
        h1 { margin: 0 0 12px; font-size: 34px; line-height: 1.15; }
        .muted { color: #65766b; }
        .badges { display: flex; gap: 8px; flex-wrap: wrap; margin: 18px 0; }
        .badge { display: inline-flex; border-radius: 999px; padding: 6px 10px; font-size: 11px; font-weight: 700; background: #e8f4ec; color: #1f6f43; }
        .info { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; margin: 20px 0; }
        .info div { border-top: 1px solid #e2e9e4; padding-top: 12px; }
        .label { display: block; font-size: 12px; color: #65766b; margin-bottom: 4px; }
        .value { font-weight: 700; }
        .desc { line-height: 1.7; color: #425248; }
        .location { margin-top: 34px; display: grid; grid-template-columns: 1fr 320px; gap: 18px; }
        .map { width: 100%; height: 340px; border-radius: 8px; border: 1px solid #dde6df; background: #e8eeea; }
        .distance { background: #fff; border: 1px solid #dde6df; border-radius: 8px; padding: 20px; }
        .distance strong { display: block; font-size: 28px; color: #123322; margin-top: 8px; }
        .related { margin-top: 34px; }
        .related-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
        .mini { background: #fff; border: 1px solid #dde6df; border-radius: 8px; padding: 16px; }
        @media (max-width: 900px) {
            .detail, .related-grid, .info, .location { grid-template-columns: 1fr; }
            .photo { min-height: 260px; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="topbar-inner">
            <a class="brand" href="{{ route('marketplace.publico.index') }}">SGRS Marketplace</a>
            <div>
                <a class="btn btn-light" href="{{ route('marketplace.publico.index') }}">Voltar</a>
                @auth
                    <a class="btn btn-primary" href="{{ route('painel.home') }}">Meu painel</a>
                @else
                    <a class="btn btn-primary" href="{{ route('painel.login') }}">Entrar para negociar</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="wrap">
        <section class="detail">
            <img class="photo" src="{{ $residuo->imagem ?: url('assets/imagens/SemImagem.png') }}" alt="{{ $residuo->tipo_material }}" onerror="this.onerror=null;this.src='{{ url('assets/imagens/SemImagem.png') }}';">
            <div class="panel">
                <h1>{{ $residuo->tipo_material }}</h1>
                <div class="muted">{{ optional($residuo->empresa)->nome }} - {{ $residuo->cidade }}/{{ $residuo->estado }}</div>
                <div class="badges">
                    <span class="badge">Documentacao validada</span>
                    <span class="badge">{{ optional($residuo->classificacao)->nome }}</span>
                </div>
                <div class="info">
                    <div><span class="label">Quantidade</span><span class="value">{{ $residuo->quantidade }} {{ optional($residuo->unidade)->nome }}</span></div>
                    <div><span class="label">Status</span><span class="value">Disponivel</span></div>
                    <div><span class="label">Classificacao</span><span class="value">{{ optional($residuo->classificacao)->codigo }}</span></div>
                    <div><span class="label">Local</span><span class="value">{{ $residuo->cidade }}/{{ $residuo->estado }}</span></div>
                </div>
                <p class="desc">{{ $residuo->descricao ?: 'Sem descricao adicional.' }}</p>
                @auth
                    <form method="POST" action="{{ route('marketplace.publico.reservar', $residuo->id) }}" style="display: inline-flex;">
                        @csrf
                        <button class="btn btn-primary" type="submit">Tenho interesse</button>
                    </form>
                @else
                    <a class="btn btn-primary" href="{{ route('painel.login') }}">Entrar para registrar interesse</a>
                @endauth
                <a class="btn btn-light" href="{{ route('painel.cadastro') }}">Cadastrar minha empresa</a>
            </div>
        </section>

        <section class="location">
            <div>
                <h2>Localizacao do residuo</h2>
                @if($residuo->latitude && $residuo->longitude)
                    <div id="residuo-map" class="map"></div>
                @else
                    <div class="panel">Este residuo ainda nao possui latitude e longitude cadastradas.</div>
                @endif
            </div>
            <div class="distance">
                <span class="muted">Distancia ate voce</span>
                <strong id="distancia-atual">Aguardando localizacao</strong>
                <p class="muted">Permita o acesso a sua localizacao no navegador para calcular a distancia aproximada ate o residuo.</p>
                <span class="label">Coordenadas</span>
                <div class="value">{{ $residuo->latitude ?: '-' }}, {{ $residuo->longitude ?: '-' }}</div>
            </div>
        </section>

        @if($relacionados->count())
            <section class="related">
                <h2>Residuos relacionados</h2>
                <div class="related-grid">
                    @foreach($relacionados as $relacionado)
                        <a class="mini" href="{{ route('marketplace.publico.show', $relacionado->id) }}">
                            <strong>{{ $relacionado->tipo_material }}</strong>
                            <div class="muted">{{ $relacionado->cidade }}/{{ $relacionado->estado }}</div>
                            <div>{{ $relacionado->quantidade }} {{ optional($relacionado->unidade)->nome }}</div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </main>
    <script src="{{ url('assets/js/sweetalert2.min.js') }}"></script>
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
    </script>
    @if(session('swal_success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Sucesso!', text: @json(session('swal_success')) });
        </script>
    @endif
    @if(session('swal_error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Oops...', text: @json(session('swal_error')) });
        </script>
    @endif
</body>
</html>
