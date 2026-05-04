@include('layout.header')
@php $empresa = $empresa ?? null; @endphp

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-fluid">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">{{ $empresa ? 'Editar empresa' : 'Nova empresa' }}</span>
                    </h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ $empresa ? route('empresas.update', $empresa->id) : route('empresas.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if($empresa) @method('PUT') @endif

                        <div class="row">
                            <div class="col-md-6 mb-7"><label class="required fs-6 fw-bold form-label">Nome</label><input name="nome" class="form-control form-control-solid" value="{{ old('nome', $empresa->nome ?? '') }}"></div>
                            <div class="col-md-3 mb-7"><label class="required fs-6 fw-bold form-label">CNPJ</label><input name="cnpj" class="form-control form-control-solid" value="{{ old('cnpj', $empresa->cnpj ?? '') }}"></div>
                            <div class="col-md-3 mb-7"><label class="required fs-6 fw-bold form-label">Telefone</label><input name="telefone" class="form-control form-control-solid" value="{{ old('telefone', $empresa->telefone ?? '') }}"></div>
                            <div class="col-md-6 mb-7"><label class="required fs-6 fw-bold form-label">E-mail</label><input name="email" type="email" class="form-control form-control-solid" value="{{ old('email', $empresa->email ?? '') }}"></div>
                            <div class="col-md-6 mb-7"><label class="required fs-6 fw-bold form-label">Tipo de industria</label><input name="tipo_industria" class="form-control form-control-solid" value="{{ old('tipo_industria', $empresa->tipo_industria ?? '') }}"></div>
                            <div class="col-md-2 mb-7"><label class="required fs-6 fw-bold form-label">CEP</label><input name="cep" class="form-control form-control-solid" value="{{ old('cep', $empresa->cep ?? '') }}"></div>
                            <div class="col-md-6 mb-7"><label class="required fs-6 fw-bold form-label">Endereco</label><input name="endereco" class="form-control form-control-solid" value="{{ old('endereco', $empresa->endereco ?? '') }}"></div>
                            <div class="col-md-2 mb-7"><label class="required fs-6 fw-bold form-label">Numero</label><input name="numero" class="form-control form-control-solid" value="{{ old('numero', $empresa->numero ?? '') }}"></div>
                            <div class="col-md-2 mb-7"><label class="required fs-6 fw-bold form-label">UF</label><input name="estado" maxlength="2" class="form-control form-control-solid text-uppercase" value="{{ old('estado', $empresa->estado ?? '') }}"></div>
                            <div class="col-md-4 mb-7"><label class="required fs-6 fw-bold form-label">Cidade</label><input name="cidade" class="form-control form-control-solid" value="{{ old('cidade', $empresa->cidade ?? '') }}"></div>
                            <div class="col-md-4 mb-7"><label class="fs-6 fw-bold form-label">Latitude</label><input type="number" step="0.0000001" name="latitude" class="form-control form-control-solid" value="{{ old('latitude', $empresa->latitude ?? '') }}"></div>
                            <div class="col-md-4 mb-7"><label class="fs-6 fw-bold form-label">Longitude</label><input type="number" step="0.0000001" name="longitude" class="form-control form-control-solid" value="{{ old('longitude', $empresa->longitude ?? '') }}"></div>

                            <div class="col-md-12 mb-4"><div class="separator separator-dashed my-4"></div><h4 class="fw-bolder">Conformidade legal</h4></div>
                            <div class="col-md-3 mb-7"><div class="form-check form-check-custom form-check-solid mt-8"><input class="form-check-input" type="checkbox" name="possui_licenca_ambiental" value="1" id="possui_licenca_ambiental" @checked(old('possui_licenca_ambiental', $empresa->possui_licenca_ambiental ?? false))><label class="form-check-label" for="possui_licenca_ambiental">Possui licenca ambiental</label></div></div>
                            <div class="col-md-3 mb-7"><div class="form-check form-check-custom form-check-solid mt-8"><input class="form-check-input" type="checkbox" name="licenca_residuos_perigosos" value="1" id="licenca_residuos_perigosos" @checked(old('licenca_residuos_perigosos', $empresa->licenca_residuos_perigosos ?? false))><label class="form-check-label" for="licenca_residuos_perigosos">Autoriza residuos perigosos</label></div></div>
                            <div class="col-md-3 mb-7"><label class="fs-6 fw-bold form-label">Numero da licenca</label><input name="numero_licenca_ambiental" class="form-control form-control-solid" value="{{ old('numero_licenca_ambiental', $empresa->numero_licenca_ambiental ?? '') }}"></div>
                            <div class="col-md-3 mb-7"><label class="fs-6 fw-bold form-label">Validade</label><input type="date" name="validade_licenca_ambiental" class="form-control form-control-solid" value="{{ old('validade_licenca_ambiental', optional($empresa->validade_licenca_ambiental ?? null)->format('Y-m-d')) }}"></div>
                            <div class="col-md-6 mb-7"><label class="fs-6 fw-bold form-label">Arquivo da licenca</label><input type="file" name="licenca_ambiental_arquivo" class="form-control form-control-solid" accept=".pdf,.jpg,.jpeg,.png">@if($empresa && $empresa->licenca_ambiental_url)<a href="{{ $empresa->licenca_ambiental_url }}" target="_blank" class="fs-7 mt-2 d-inline-block">Ver licenca atual</a>@endif</div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('empresas.index') }}" class="btn btn-light">Cancelar</a>
                            <button class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout.footer')
@include('painel.shared.alerts')
</body>
</html>
