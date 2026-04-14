<html lang="pt">

<head>
    <title>SGRS – Sistema de Gestão de Resíduos Sustentáveis</title>
    <link rel="shortcut icon" href="{{ url('assets/imagens/logo.png') }}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta name="robots" content="noindex,nofollow">
    <meta NAME="robots" CONTENT="noarchive">
    <meta NAME="robots" CONTENT="index, nofollow, noarchive">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Security-Policy"
        content="default-src 'self'; img-src 'self'; child-src 'none'; script-src 'self'; style-src 'self' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; ">
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ url('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
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
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed"
            style="background-color: #f3f3f3;">
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
                    <form class="form w-100" method="post" action="{{-- route('sgrs.cadastro.store') --}}">
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
                                <input class="form-control form-control-lg form-control-solid" type="text" name="nome" 
                                    value="{{ old('nome') }}" required placeholder="Ex: Indústria ABC Ltda" />
                            </div>

                            <div class="row g-5 mb-7">
                                <!-- CNPJ -->
                                <div class="col-md-6">
                                    <label class="form-label fs-6 fw-bolder text-dark">CNPJ</label>
                                    <input class="form-control form-control-lg form-control-solid" type="text" name="cnpj" 
                                        value="{{ old('cnpj') }}" placeholder="00.000.000/0000-00" id="cnpj" />
                                    <small class="text-muted">Opcional, mas recomendado para maior credibilidade</small>
                                </div>
                                
                                <!-- Tipo de Indústria -->
                                <div class="col-md-6">
                                    <label class="form-label fs-6 fw-bolder text-dark required">Tipo de Indústria</label>
                                    <select class="form-select form-select-lg form-select-solid" name="tipo_industria" required>
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
                                    <input class="form-control form-control-lg form-control-solid" type="tel" name="telefone" 
                                        value="{{ old('telefone') }}" required placeholder="(00) 00000-0000" id="telefone" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fs-6 fw-bolder text-dark required">E-mail</label>
                                    <input class="form-control form-control-lg form-control-solid" type="email" name="email" 
                                        value="{{ old('email') }}" required placeholder="contato@empresa.com" />
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
                                <div class="col-md-8">
                                    <label class="form-label fs-6 fw-bolder text-dark required">Endereço</label>
                                    <input class="form-control form-control-lg form-control-solid" type="text" name="endereco" 
                                        value="{{ old('endereco') }}" required placeholder="Rua, número, bairro" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fs-6 fw-bolder text-dark required">CEP</label>
                                    <input class="form-control form-control-lg form-control-solid" type="text" name="cep" 
                                        value="{{ old('cep') }}" required placeholder="00000-000" id="cep" />
                                </div>
                            </div>

                            <div class="row g-5 mb-7">
                                <div class="col-md-6">
                                    <label class="form-label fs-6 fw-bolder text-dark required">Cidade</label>
                                    <input class="form-control form-control-lg form-control-solid" type="text" name="cidade" 
                                        value="{{ old('cidade') }}" required placeholder="São Paulo" id="cidade" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fs-6 fw-bolder text-dark required">Estado</label>
                                    <select class="form-select form-select-lg form-select-solid" name="estado" required id="estado">
                                        <option value="">Selecione...</option>
                                        <option value="AC">AC</option><option value="AL">AL</option><option value="AP">AP</option>
                                        <option value="AM">AM</option><option value="BA">BA</option><option value="CE">CE</option>
                                        <option value="DF">DF</option><option value="ES">ES</option><option value="GO">GO</option>
                                        <option value="MA">MA</option><option value="MT">MT</option><option value="MS">MS</option>
                                        <option value="MG">MG</option><option value="PA">PA</option><option value="PB">PB</option>
                                        <option value="PR">PR</option><option value="PE">PE</option><option value="PI">PI</option>
                                        <option value="RJ">RJ</option><option value="RN">RN</option><option value="RS">RS</option>
                                        <option value="RO">RO</option><option value="RR">RR</option><option value="SC">SC</option>
                                        <option value="SP">SP</option><option value="SE">SE</option><option value="TO">TO</option>
                                    </select>
                                </div>
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
                                    <input class="form-control form-control-lg form-control-solid" type="text" name="admin_nome" 
                                        value="{{ old('admin_nome') }}" required placeholder="Nome do responsável" />
                                    <small class="text-muted">Será o primeiro usuário administrador do sistema</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fs-6 fw-bolder text-dark required">E-mail do Administrador</label>
                                    <input class="form-control form-control-lg form-control-solid" type="email" name="admin_email" 
                                        value="{{ old('admin_email') }}" required placeholder="admin@empresa.com" />
                                </div>
                            </div>

                            <div class="row g-5 mb-7">
                                <div class="col-md-6">
                                    <label class="form-label fs-6 fw-bolder text-dark required">Senha</label>
                                    <input class="form-control form-control-lg form-control-solid" type="password" name="senha" 
                                        required placeholder="Mínimo 6 caracteres" id="senha" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fs-6 fw-bolder text-dark required">Confirmar Senha</label>
                                    <input class="form-control form-control-lg form-control-solid" type="password" name="senha_confirmacao" 
                                        required placeholder="Digite a senha novamente" />
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
                                <i class="fas fa-check-circle me-2"></i>Cadastrar Empresa
                            </button>
                            <a href="{{ route('painel.login') }}" class="btn btn-lg btn-secondary w-100 mb-5">
                                <i class="fas fa-arrow-left me-2"></i>Voltar para Login
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
    <script src="{{ url('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ url('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->

    <!--begin::Masks e Autocomplete-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    
    <!--begin::Page Custom Javascript-->
    <script>
        $(document).ready(function() {
            // Máscaras
            $('#cnpj').mask('00.000.000/0000-00');
            $('#telefone').mask('(00) 00000-0000');
            $('#cep').mask('00000-000');
            
            // Busca automática de endereço pelo CEP (ViaCEP)
            $('#cep').blur(function() {
                var cep = $(this).val().replace(/\D/g, '');
                if (cep.length === 8) {
                    $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
                        if (!data.erro) {
                            $('#endereco').val(`${data.logradouro}, ${data.bairro}`);
                            $('#cidade').val(data.localidade);
                            $('#estado').val(data.uf);
                            
                            // Busca latitude/longitude (Google Geocoding - opcional)
                            buscarLatLong(data.logradouro, data.localidade, data.uf);
                        } else {
                            alert('CEP não encontrado');
                        }
                    });
                }
            });
            
            // Função para buscar latitude/longitude (usando Nominatim - OpenStreetMap)
            function buscarLatLong(endereco, cidade, estado) {
                var query = `${endereco}, ${cidade}, ${estado}, Brasil`;
                $.getJSON(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`, function(data) {
                    if (data && data.length > 0) {
                        $('#latitude').val(data[0].lat);
                        $('#longitude').val(data[0].lon);
                    }
                });
            }
        });
    </script>
    <!--end::Page Custom Javascript-->

</body>
<!--end::Body
