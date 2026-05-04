<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Marketplace de Residuos | SGRS</title>
    <link rel="shortcut icon" href="{{ url('assets/imagens/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700">
    <link href="{{ url('assets/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Poppins, Arial, sans-serif; color: #17212b; background: #f4f7f5; }
        a { color: inherit; text-decoration: none; }
        .topbar { position: sticky; top: 0; z-index: 10; background: rgba(255,255,255,.94); border-bottom: 1px solid #dde6df; backdrop-filter: blur(10px); }
        .topbar-inner { max-width: 1180px; margin: 0 auto; padding: 14px 22px; display: flex; align-items: center; justify-content: space-between; gap: 18px; }
        .brand { font-weight: 700; font-size: 18px; color: #123322; }
        .nav-actions { display: flex; gap: 10px; align-items: center; }
        .btn { display: inline-flex; align-items: center; justify-content: center; min-height: 40px; padding: 0 16px; border-radius: 6px; border: 1px solid #1f6f43; font-weight: 600; font-size: 13px; }
        button.btn { font-family: inherit; cursor: pointer; }
        .btn-primary { background: #1f6f43; color: #fff; }
        .btn-light { background: #fff; color: #1f6f43; }
        .hero { min-height: 520px; display: flex; align-items: center; background: linear-gradient(90deg, rgba(10,32,22,.86), rgba(10,32,22,.50)), url('{{ optional($residuos->first())->imagem ?: url('assets/imagens/SemImagem.png') }}') center/cover; color: #fff; }
        .hero-inner { max-width: 1180px; width: 100%; margin: 0 auto; padding: 62px 22px 48px; }
        .hero h1 { max-width: 760px; margin: 0 0 14px; font-size: 44px; line-height: 1.08; letter-spacing: 0; }
        .hero p { max-width: 650px; margin: 0 0 26px; color: #dce9df; font-size: 16px; line-height: 1.7; }
        .stats { display: grid; grid-template-columns: repeat(3, minmax(0, 160px)); gap: 12px; margin-top: 34px; }
        .stat { border-left: 3px solid #79c795; padding-left: 14px; }
        .stat strong { display: block; font-size: 25px; }
        .stat span { color: #c7d8cc; font-size: 12px; }
        .section { max-width: 1180px; margin: 0 auto; padding: 34px 22px 56px; }
        .filters { margin-top: -52px; background: #fff; border: 1px solid #dde6df; border-radius: 8px; padding: 18px; box-shadow: 0 18px 50px rgba(19,49,35,.13); }
        .filter-grid { display: grid; grid-template-columns: 2fr 1.2fr 1fr 1fr auto; gap: 12px; }
        input, select { width: 100%; min-height: 42px; border: 1px solid #d7e1da; border-radius: 6px; padding: 0 12px; font-family: inherit; color: #17212b; background: #fff; }
        .section-title { display: flex; justify-content: space-between; align-items: end; gap: 18px; margin: 34px 0 18px; }
        .section-title h2 { margin: 0; font-size: 26px; }
        .section-title p { margin: 4px 0 0; color: #65766b; }
        .grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; }
        .card { background: #fff; border: 1px solid #dde6df; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; min-height: 100%; }
        .card img { width: 100%; height: 190px; object-fit: cover; background: #e8eeea; }
        .card-body { padding: 18px; display: flex; flex-direction: column; flex: 1; }
        .badges { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 10px; }
        .badge { display: inline-flex; border-radius: 999px; padding: 5px 9px; font-size: 11px; font-weight: 700; background: #e8f4ec; color: #1f6f43; }
        .badge-muted { background: #eef1f4; color: #5c6871; }
        .card h3 { margin: 0 0 8px; font-size: 18px; }
        .muted { color: #65766b; font-size: 13px; }
        .desc { margin: 12px 0 16px; color: #4d5b52; line-height: 1.55; font-size: 13px; }
        .card-footer { margin-top: auto; display: flex; justify-content: space-between; align-items: center; gap: 12px; }
        .card-actions { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; justify-content: flex-end; }
        .qty { font-weight: 700; color: #123322; }
        .pagination { margin-top: 26px; }
        .pagination nav { display: flex; justify-content: center; }
        .pagination svg { width: 16px !important; height: 16px !important; }
        .pagination .hidden { display: none !important; }
        .empty { background: #fff; border: 1px solid #dde6df; border-radius: 8px; padding: 28px; color: #65766b; }
        @media (max-width: 900px) {
            .hero h1 { font-size: 32px; }
            .filter-grid, .grid, .stats { grid-template-columns: 1fr; }
            .hero { min-height: auto; }
            .filters { margin-top: -30px; }
            .topbar-inner { align-items: flex-start; flex-direction: column; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="topbar-inner">
            <a class="brand" href="{{ route('marketplace.publico.index') }}">SGRS Marketplace</a>
            <div class="nav-actions">
                @auth
                    <a class="btn btn-primary" href="{{ route('painel.home') }}">Meu painel</a>
                @else
                    <a class="btn btn-light" href="{{ route('painel.login') }}">Entrar</a>
                    <a class="btn btn-primary" href="{{ route('painel.cadastro') }}">Cadastrar empresa</a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="hero-inner">
                <h1>Residuos industriais disponiveis para reaproveitamento</h1>
                <p>Encontre materiais com documentacao validada, empresas identificadas e oportunidades para reduzir custos, emissao de carbono e desperdicio operacional.</p>
                <a class="btn btn-primary" href="#residuos">Ver residuos disponiveis</a>

                <div class="stats">
                    <div class="stat"><strong>{{ $totalDisponivel }}</strong><span>residuos disponiveis</span></div>
                    <div class="stat"><strong>{{ $totalEmpresas }}</strong><span>empresas geradoras</span></div>
                    <div class="stat"><strong>{{ $totalEstados }}</strong><span>estados com ofertas</span></div>
                </div>
            </div>
        </section>

        <section class="section" id="residuos">
            <form class="filters" method="GET" action="{{ route('marketplace.publico.index') }}">
                <div class="filter-grid">
                    <input type="text" name="busca" value="{{ request('busca') }}" placeholder="Buscar por material, descricao ou empresa">
                    <select name="classificacao_id">
                        <option value="">Todas as classificacoes</option>
                        @foreach($classificacoes as $classificacao)
                            <option value="{{ $classificacao->id }}" @selected((string) request('classificacao_id') === (string) $classificacao->id)>{{ $classificacao->nome }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="cidade" value="{{ request('cidade') }}" placeholder="Cidade">
                    <input type="text" name="estado" value="{{ request('estado') }}" maxlength="2" placeholder="UF">
                    <button class="btn btn-primary" type="submit">Filtrar</button>
                </div>
            </form>

            <div class="section-title">
                <div>
                    <h2>Ofertas em destaque</h2>
                    <p>Materiais listados por empresas cadastradas no SGRS.</p>
                </div>
            </div>

            <div class="grid">
                @forelse($residuos as $residuo)
                    <article class="card">
                        <img src="{{ $residuo->imagem ?: url('assets/imagens/SemImagem.png') }}" alt="{{ $residuo->tipo_material }}" onerror="this.onerror=null;this.src='{{ url('assets/imagens/SemImagem.png') }}';">
                        <div class="card-body">
                            <div class="badges">
                                <span class="badge">Documentacao validada</span>
                                @if(optional($residuo->classificacao)->eh_perigoso)
                                    <span class="badge badge-muted">Perigoso</span>
                                @endif
                            </div>
                            <h3>{{ $residuo->tipo_material }}</h3>
                            <div class="muted">{{ optional($residuo->empresa)->nome }} - {{ $residuo->cidade }}/{{ $residuo->estado }}</div>
                            <p class="desc">{{ \Illuminate\Support\Str::limit($residuo->descricao, 120) }}</p>
                            <div class="card-footer">
                                <span class="qty">{{ $residuo->quantidade }} {{ optional($residuo->unidade)->nome }}</span>
                                <div class="card-actions">
                                    @auth
                                        <form method="POST" action="{{ route('marketplace.publico.reservar', $residuo->id) }}">
                                            @csrf
                                            <button class="btn btn-primary" type="submit">Tenho interesse</button>
                                        </form>
                                    @endauth
                                    <a class="btn btn-light" href="{{ route('marketplace.publico.show', $residuo->id) }}">Ver detalhes</a>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="empty">Nenhum residuo disponivel com os filtros informados.</div>
                @endforelse
            </div>

            <div class="pagination">
                {{ $residuos->links() }}
            </div>
        </section>
    </main>
    <script src="{{ url('assets/js/sweetalert2.min.js') }}"></script>
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
