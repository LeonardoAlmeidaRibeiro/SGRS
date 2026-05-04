@include('layout.header')

@php
    $tabAtiva = session('perfil_tab', 'dados');
    $empresaUsuario = optional($usuario)->empresa;
@endphp

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-fluid">

            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Meu Perfil</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Atualize seus dados pessoais e endereço pessoal</span>
                    </h3>
                </div>

                <div class="card-body">
                    <div class="row mb-8">
                        <div class="col-md-3 mb-5">
                            <div class="text-muted fw-bold">Nome</div>
                            <div class="fs-5 fw-bolder">{{ $usuario->name }}</div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <div class="text-muted fw-bold">E-mail</div>
                            <div class="fs-5">{{ $usuario->email }}</div>
                        </div>

                        <div class="col-md-2 mb-5">
                            <div class="text-muted fw-bold">Perfil</div>
                            <div class="fs-5">{{ ucfirst($usuario->perfil) }}</div>
                        </div>

                        <div class="col-md-4 mb-5">
                            <div class="text-muted fw-bold">Empresa vinculada</div>
                            <div class="fs-5">
                                @if($empresaUsuario)
                                    {{ $empresaUsuario->nome }}
                                    <a href="{{ route('empresas.show', $empresaUsuario->id) }}" class="btn btn-sm btn-light-info ms-2">Ver empresa</a>
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <div class="text-muted fw-bold">Telefone</div>
                            <div class="fs-5">{{ $usuario->telefone ?: '-' }}</div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <div class="text-muted fw-bold">CPF</div>
                            <div class="fs-5">{{ $usuario->cpf ?: '-' }}</div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <div class="text-muted fw-bold">Nascimento</div>
                            <div class="fs-5">{{ optional($usuario->data_nascimento)->format('d/m/Y') ?: '-' }}</div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <div class="text-muted fw-bold">Localizacao</div>
                            <div class="fs-5">{{ $usuario->cidade ? $usuario->cidade . '/' . $usuario->estado : '-' }}</div>
                        </div>
                    </div>

                    <div class="separator separator-dashed mb-8"></div>

                    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                        <li class="nav-item">
                            <a class="nav-link {{ $tabAtiva === 'dados' ? 'active' : '' }}" data-bs-toggle="tab" href="#tab_dados_pessoais">
                                Dados pessoais
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $tabAtiva === 'endereco' ? 'active' : '' }}" data-bs-toggle="tab" href="#tab_endereco_pessoal">
                                Endereço pessoal
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade {{ $tabAtiva === 'dados' ? 'show active' : '' }}" id="tab_dados_pessoais" role="tabpanel">
                            @if (session('success_dados'))
                                <div class="alert alert-success">{{ session('success_dados') }}</div>
                            @endif

                            @if ($errors->dadosPessoais->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->dadosPessoais->all() as $erro)
                                        <div>{{ $erro }}</div>
                                    @endforeach
                                </div>
                            @endif

                            <form method="POST" action="{{ route('perfil.dados-pessoais.update') }}">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6 mb-7">
                                        <label class="required fs-6 fw-bold form-label mb-2">Nome</label>
                                        <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name', $usuario->name) }}">
                                    </div>

                                    <div class="col-md-6 mb-7">
                                        <label class="required fs-6 fw-bold form-label mb-2">E-mail</label>
                                        <input type="email" class="form-control form-control-solid" name="email" value="{{ old('email', $usuario->email) }}">
                                    </div>

                                    <div class="col-md-4 mb-7">
                                        <label class="fs-6 fw-bold form-label mb-2">Telefone</label>
                                        <input type="text" class="form-control form-control-solid" name="telefone" id="telefone" maxlength="15" placeholder="(00) 00000-0000" value="{{ old('telefone', $usuario->telefone) }}">
                                    </div>

                                    <div class="col-md-4 mb-7">
                                        <label class="fs-6 fw-bold form-label mb-2">CPF</label>
                                        <input type="text" class="form-control form-control-solid" name="cpf" id="cpf" maxlength="14" placeholder="000.000.000-00" value="{{ old('cpf', $usuario->cpf) }}">
                                    </div>

                                    <div class="col-md-4 mb-7">
                                        <label class="fs-6 fw-bold form-label mb-2">Data de nascimento</label>
                                        <input type="date" class="form-control form-control-solid" name="data_nascimento" value="{{ old('data_nascimento', optional($usuario->data_nascimento)->format('Y-m-d')) }}">
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Salvar dados pessoais</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade {{ $tabAtiva === 'endereco' ? 'show active' : '' }}" id="tab_endereco_pessoal" role="tabpanel">
                            @if (session('success_endereco'))
                                <div class="alert alert-success">{{ session('success_endereco') }}</div>
                            @endif

                            @if ($errors->endereco->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->endereco->all() as $erro)
                                        <div>{{ $erro }}</div>
                                    @endforeach
                                </div>
                            @endif

                            <form method="POST" action="{{ route('perfil.endereco.update') }}">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-3 mb-7">
                                        <label class="fs-6 fw-bold form-label mb-2">CEP</label>
                                        <input type="text" class="form-control form-control-solid" name="cep" id="cep" maxlength="9" placeholder="00000-000" value="{{ old('cep', $usuario->cep) }}">
                                    </div>

                                    <div class="col-md-7 mb-7">
                                        <label class="fs-6 fw-bold form-label mb-2">Endereço</label>
                                        <input type="text" class="form-control form-control-solid" name="endereco" id="endereco" value="{{ old('endereco', $usuario->endereco) }}">
                                    </div>

                                    <div class="col-md-2 mb-7">
                                        <label class="fs-6 fw-bold form-label mb-2">Número</label>
                                        <input type="text" class="form-control form-control-solid" name="numero" value="{{ old('numero', $usuario->numero) }}">
                                    </div>

                                    <div class="col-md-4 mb-7">
                                        <label class="fs-6 fw-bold form-label mb-2">Complemento</label>
                                        <input type="text" class="form-control form-control-solid" name="complemento" value="{{ old('complemento', $usuario->complemento) }}">
                                    </div>

                                    <div class="col-md-4 mb-7">
                                        <label class="fs-6 fw-bold form-label mb-2">Bairro</label>
                                        <input type="text" class="form-control form-control-solid" name="bairro" id="bairro" value="{{ old('bairro', $usuario->bairro) }}">
                                    </div>

                                    <div class="col-md-3 mb-7">
                                        <label class="fs-6 fw-bold form-label mb-2">Cidade</label>
                                        <input type="text" class="form-control form-control-solid" name="cidade" id="cidade" value="{{ old('cidade', $usuario->cidade) }}">
                                    </div>

                                    <div class="col-md-1 mb-7">
                                        <label class="fs-6 fw-bold form-label mb-2">UF</label>
                                        <input type="text" class="form-control form-control-solid text-uppercase" name="estado" id="estado" maxlength="2" value="{{ old('estado', $usuario->estado) }}">
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Salvar endereco</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('layout.footer')

<script>
    $(document).ready(function () {
        function somenteNumeros(valor) {
            return valor.replace(/\D/g, '');
        }

        function mascaraTelefone(valor) {
            var numeros = somenteNumeros(valor).slice(0, 11);

            if (numeros.length <= 10) {
                return numeros
                    .replace(/^(\d{2})(\d)/, '($1) $2')
                    .replace(/(\d{4})(\d)/, '$1-$2');
            }

            return numeros
                .replace(/^(\d{2})(\d)/, '($1) $2')
                .replace(/(\d{5})(\d)/, '$1-$2');
        }

        function mascaraCpf(valor) {
            return somenteNumeros(valor)
                .slice(0, 11)
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }

        function mascaraCep(valor) {
            return somenteNumeros(valor)
                .slice(0, 8)
                .replace(/(\d{5})(\d)/, '$1-$2');
        }

        if ($.fn.mask) {
            $('#telefone').mask('(00) 00000-0000');
            $('#cpf').mask('000.000.000-00');
            $('#cep').mask('00000-000');
        } else {
            $('#telefone').on('input', function () {
                $(this).val(mascaraTelefone($(this).val()));
            });

            $('#cpf').on('input', function () {
                $(this).val(mascaraCpf($(this).val()));
            });

            $('#cep').on('input', function () {
                $(this).val(mascaraCep($(this).val()));
            });
        }

        $('#cep').on('blur', function () {
            var cep = $(this).val().replace(/\D/g, '');

            if (cep.length !== 8) {
                return;
            }

            $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function (data) {
                if (data.erro) {
                    return;
                }

                $('#endereco').val(data.logradouro);
                $('#bairro').val(data.bairro);
                $('#cidade').val(data.localidade);
                $('#estado').val(data.uf);
            });
        });
    });
</script>

</body>
</html>
