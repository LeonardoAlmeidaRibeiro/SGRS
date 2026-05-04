@include('layout.header')

@php $interesse = $interesse ?? null; @endphp

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-fluid">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">{{ $interesse ? 'Editar Interesse' : 'Novo Interesse' }}</span>
                    </h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ $interesse ? route('interesses.update', $interesse->id) : route('interesses.store') }}">
                        @csrf
                        @if($interesse) @method('PUT') @endif

                        <div class="row">
                            <div class="col-md-6 mb-7">
                                <label class="fs-6 fw-bold form-label required">Empresa</label>
                                <select name="empresa_id" class="form-select form-select-solid">
                                    <option value="">Empresa logada</option>
                                    @foreach($empresas as $empresa)
                                        <option value="{{ $empresa->id }}" @selected((string) old('empresa_id', $interesse->empresa_id ?? optional(Auth::user())->empresa_id) === (string) $empresa->id)>{{ $empresa->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-7">
                                <label class="fs-6 fw-bold form-label required">Tipo de material</label>
                                <input name="tipo_material" class="form-control form-control-solid" value="{{ old('tipo_material', $interesse->tipo_material ?? '') }}">
                            </div>
                            <div class="col-md-4 mb-7">
                                <label class="fs-6 fw-bold form-label required">Classificação</label>
                                <select name="classificacao_id" class="form-select form-select-solid">
                                    <option value="">Selecione</option>
                                    @foreach($classificacoes as $classificacao)
                                        <option value="{{ $classificacao->id }}" @selected((string) old('classificacao_id', $interesse->classificacao_id ?? '') === (string) $classificacao->id)>{{ $classificacao->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-7">
                                <label class="fs-6 fw-bold form-label">Quantidade mínima</label>
                                <input type="number" step="0.001" min="0" name="quantidade_minima" class="form-control form-control-solid" value="{{ old('quantidade_minima', $interesse->quantidade_minima ?? '') }}">
                            </div>
                            <div class="col-md-3 mb-7">
                                <label class="fs-6 fw-bold form-label">Quantidade máxima</label>
                                <input type="number" step="0.001" min="0" name="quantidade_maxima" class="form-control form-control-solid" value="{{ old('quantidade_maxima', $interesse->quantidade_maxima ?? '') }}">
                            </div>
                            <div class="col-md-2 mb-7">
                                <label class="fs-6 fw-bold form-label">Raio km</label>
                                <input type="number" step="0.01" min="0" name="raio_km" class="form-control form-control-solid" value="{{ old('raio_km', $interesse->raio_km ?? '') }}">
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('interesses.index') }}" class="btn btn-light">Cancelar</a>
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
</body></html>
