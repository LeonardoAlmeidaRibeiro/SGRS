<html lang="pt">

<head>
    <meta charset="utf-8" />
    <title>SGRS – Sistema de Gestão de Resíduos Sustentáveis</title>

    <link rel="shortcut icon" href="{{ url('assets/imagens/logo.png') }}" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- SEO (corrigido e sem conflito) -->
    <meta name="robots" content="noindex, nofollow, noarchive">

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script>
    <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript" />
    </script>


    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    <!-- CSS Global -->
    <link href="{{ url('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<style>
    #botmanWidgetRoot {
        display: none;
    }

</style>

<body id="kt_body" class="header-tablet-and-mobile-fixed aside-enabled">

    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Cadastro de Empresa-->
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-color: #f3f3f3;">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <!--begin::Logo-->
                <a href="#" class="mb-12">
                    <img alt="Logo" src="{{ url('assets/imagens/logo.png') }}" width="230px" />
                </a>
                <h1 class="text-center">SGRS – Sistema de Gestão de Resíduos Sustentáveis</h1>
                <p class="text-muted text-center">Cadastre sua empresa e comece a promover a economia circular</p>
                <br>
                <!--end::Logo-->
                <!--begin::Wrapper-->
                <div class="w-lg-700px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <!--begin::Form-->
                    <form class="form w-100" method="post" action="{{-- route('painel.cadastro.store') --}}">
                        @csrf

                        @if ($errors->all())
                        @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>
                        @endforeach
                        @endif

                        @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif

                        <!--begin::Heading-->
                        <div class="text-center mb-10">
                            <h2 class="mb-3">Dados da Empresa</h2>
                            <div class="text-muted">Preencha as informações abaixo para se cadastrar</div>
                        </div>
                        <!--end::Heading-->

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-8"></div>
                        <!--end::Separator-->

                        <!--begin::Informações Básicas-->
                        <div class="mb-8">
                            <h5 class="mb-5">Informações Básicas</h5>

                            <!-- Nome da Empresa -->
                            <div class="fv-row mb-7">
                                <label class="form-label fs-6 fw-bolder text-dark required">Nome da Empresa</label>
                                <input class="form-control form-control-lg form-control-solid" type="text" name="nome" value="{{ old('nome') }}" />
                            </div>

                            <div class="row g-5 mb-7">
                                <!-- CNPJ -->
                                <div class="col-md-6">
                                    <label class="form-label fs-6 fw-bolder text-dark required">CNPJ</label>
                                    <input class="form-control form-control-lg form-control-solid" type="text" id="cnpj" name="cnpj" value="{{ old('cnpj') }}" placeholder="00.000.000/0000-00">
                                </div>

                                <!-- Tipo de Indústria -->
                                <div class="col-md-6">
                                    <label class="form-label fs-6 fw-bolder text-dark required">Tipo de Indústria</label>
                                    <select class="form-select form-select-solid" data-control="select2" name="tipo_industria" required>
                                        <option value="">Selecione...</option>
                                        <option value="alimenticia" {{ old('tipo_industria') == 'alimenticia' ? 'selected' : '' }}>Alimentícia</option>
                                        <option value="quimica" {{ old('tipo_industria') == 'quimica' ? 'selected' : '' }}>Química</option>
                                        <option value="farmaceutica" {{ old('tipo_industria') == 'farmaceutica' ? 'selected' : '' }}>Farmacêutica</option>
                                        <option value="metalurgica" {{ old('tipo_industria') == 'metalurgica' ? 'selected' : '' }}>Metalúrgica</option>
                                        <option value="plastico" {{ old('tipo_industria') == 'plastico' ? 'selected' : '' }}>Plástico e Borracha</option>
                                        <option value="papel" {{ old('tipo_industria') == 'papel' ? 'selected' : '' }}>Papel e Celulose</option>
                                        <option value="textil" {{ old('tipo_industria') == 'textil' ? 'selected' : '' }}>Têxtil</option>
                                        <option value="eletronico" {{ old('tipo_industria') == 'eletronico' ? 'selected' : '' }}>Eletrônico</option>
                                        <option value="construcao" {{ old('tipo_industria') == 'construcao' ? 'selected' : '' }}>Construção Civil</option>
                                        <option value="automotivo" {{ old('tipo_industria') == 'automotivo' ? 'selected' : '' }}>Automotivo</option>
                                        <option value="outros" {{ old('tipo_industria') == 'outros' ? 'selected' : '' }}>Outros</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Telefone e Email -->
                            <div class="row g-5 mb-7">
                                <div class="col-md-6">
                                    <label class="form-label fs-6 fw-bolder text-dark required">Telefone</label>
                                    <input class="form-control form-control-lg form-control-solid" type="tel" name="telefone" value="{{ old('telefone') }}" id="telefone" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fs-6 fw-bolder text-dark required">E-mail</label>
                                    <input class="form-control form-control-lg form-control-solid" type="email" name="email" value="{{ old('email') }}" />
                                </div>
                            </div>
                        </div>

                        <!--begin::Separator-->
                        <div class="separator separator-dashed my-8"></div>
                        <!--end::Separator-->

                        <!--begin::Endereço-->
                        <div class="mb-8">
                            <h5 class="mb-5">Endereço da Empresa</h5>

                            <div class="row g-5 mb-7">
                                <div class="col-md-4">
                                    <label class="form-label fs-6 fw-bolder text-dark required">CEP</label>
                                    <input class="form-control form-control-lg form-control-solid" type="text" name="cep" value="{{ old('cep') }}" id="cep" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fs-6 fw-bolder text-dark required">Endereço</label>
                                    <input class="form-control form-control-lg form-control-solid" type="text" id="endereco" name="endereco" value="{{ old('endereco') }}" />
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fs-6 fw-bolder text-dark required">Número</label>
                                    <input class="form-control form-control-lg form-control-solid" type="text" name="numero" value="{{ old('numero') }}" />
                                </div>

                            </div>

                            <div class="row g-5 mb-7">
                                <div class="col-md-6">
                                    <label class="form-label fs-6 fw-bolder text-dark required">Estado</label>
                                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="Selecione" name="estado" required id="estado">
                                        <option value="">Selecione</option>
                                        @foreach ( $estados as $estado )
                                        <option value="{{ $estado->id }}">{{ $estado->nome }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fs-6 fw-bolder text-dark required">Cidade</label>
                                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="Selecione" name="cidade" required id="cidade">
                                        <option value="">Selecione</option>
                                        @foreach ( $cidades as $cidade )
                                        <option value="{{ $cidade->id }}">{{ $cidade->nome }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <!-- Latitude e Longitude (ocultos, preenchidos automaticamente via API) -->
                                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}" />
                                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}" />
                            </div>

                            <!--begin::Separator-->
                            <div class="separator separator-dashed my-8"></div>
                            <!--end::Separator-->

                            <!--begin::Acesso ao Sistema-->
                            <div class="mb-8">
                                <h5 class="mb-5">Acesso ao Sistema</h5>

                                <div class="row g-5 mb-7">
                                    <div class="col-md-6">
                                        <label class="form-label fs-6 fw-bolder text-dark required">Nome do Administrador</label>
                                        <input class="form-control form-control-lg form-control-solid" type="text" name="admin_nome" value="{{ old('admin_nome') }}" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fs-6 fw-bolder text-dark required">E-mail do Administrador</label>
                                        <input class="form-control form-control-lg form-control-solid" type="email" name="admin_email" value="{{ old('admin_email') }}" />
                                    </div>
                                </div>

                                <div class="row g-5 mb-7">
                                    <div class="col-md-6">
                                        <label class="form-label fs-6 fw-bolder text-dark required">Senha</label>
                                        <input class="form-control form-control-lg form-control-solid" type="password" name="senha" id="senha" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fs-6 fw-bolder text-dark required">Confirmar Senha</label>
                                        <input class="form-control form-control-lg form-control-solid" type="password" name="senha_confirmacao" />
                                    </div>
                                </div>
                            </div>

                            <!--begin::Separator-->
                            <div class="separator separator-dashed my-8"></div>
                            <!--end::Separator-->

                            <!--begin::Termos e Condições-->
                            <div class="fv-row mb-10">
                                <label class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" name="termos" value="1" required />
                                    <span class="form-check-label text-muted">
                                        Li e aceito os <a href="#" class="text-primary">Termos de Uso</a> e a
                                        <a href="#" class="text-primary">Política de Privacidade</a>
                                    </span>
                                </label>
                            </div>
                            <!--end::Termos e Condições-->

                            <!--begin::Actions-->
                            <div class="text-center">
                                <button type="submit" class="btn btn-lg btn-primary w-100 mb-5">
                                    Cadastrar Empresa
                                </button>
                                <a href="{{ route('painel.login') }}" class="btn btn-lg btn-secondary w-100 mb-5">
                                    Voltar
                                </a>
                            </div>
                            <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Cadastro de Empresa-->
    </div>
    <!--end::Main-->

    <!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <!--begin::Javascript-->

    <!-- jQuery + plugins (Metronic já inclui jQuery aqui) -->
    <script src="{{ url('assets/plugins/global/plugins.bundle.js') }}"></script>

    <!-- Scripts do template -->
    <script src="{{ url('assets/js/scripts.bundle.js') }}"></script>

    <!-- Plugin de máscara (UMA VEZ só) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- Seu script -->
    <script>
        $(document).ready(function() {

            $("#cnpj").mask("00.000.000/0000-00");
            $("#telefone").mask("(00) 00000-0000");
            $("#cep").mask("00000-000");

        });

    </script>

    <!--end::Javascript-->

    <!--end::Page Custom Javascript-->

</body>
<!--end::Body
