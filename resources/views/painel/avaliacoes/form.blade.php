@include('layout.header')
@php $avaliacao = $avaliacao ?? null; @endphp

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-fluid">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">{{ $avaliacao ? 'Editar Avaliacao' : 'Nova Avaliacao' }}</span>
                    </h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ $avaliacao ? route('avaliacoes.update', $avaliacao->id) : route('avaliacoes.store') }}">
                        @csrf
                        @if($avaliacao) @method('PUT') @endif

                        <div class="row">
                            <div class="col-md-4 mb-7">
                                <label class="required fs-6 fw-bold form-label">Transacao</label>
                                <select name="transacao_id" class="form-select form-select-solid">
                                    <option value="">Selecione</option>
                                    @foreach($transacoes as $transacao)
                                        <option value="{{ $transacao->id }}" @selected((string) old('transacao_id', $avaliacao->transacao_id ?? '') === (string) $transacao->id)>
                                            #{{ $transacao->id }} - {{ optional($transacao->residuo)->tipo_material }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-7">
                                <label class="required fs-6 fw-bold form-label">Empresa avaliadora</label>
                                <select name="empresa_avaliadora_id" class="form-select form-select-solid">
                                    <option value="">Selecione</option>
                                    @foreach($empresas as $empresa)
                                        <option value="{{ $empresa->id }}" @selected((string) old('empresa_avaliadora_id', $avaliacao->empresa_avaliadora_id ?? '') === (string) $empresa->id)>{{ $empresa->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-7">
                                <label class="required fs-6 fw-bold form-label">Empresa avaliada</label>
                                <select name="empresa_avaliada_id" class="form-select form-select-solid">
                                    <option value="">Selecione</option>
                                    @foreach($empresas as $empresa)
                                        <option value="{{ $empresa->id }}" @selected((string) old('empresa_avaliada_id', $avaliacao->empresa_avaliada_id ?? '') === (string) $empresa->id)>{{ $empresa->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 mb-7">
                                <label class="required fs-6 fw-bold form-label">Nota</label>
                                <input type="number" name="nota" min="1" max="5" class="form-control form-control-solid" value="{{ old('nota', $avaliacao->nota ?? 5) }}">
                            </div>

                            <div class="col-md-4 mb-7">
                                <label class="fs-6 fw-bold form-label">Conformidade</label>
                                <div class="form-check form-check-custom form-check-solid mt-3">
                                    <input class="form-check-input" type="checkbox" name="residuo_conforme" value="1" id="residuo_conforme" @checked(old('residuo_conforme', $avaliacao->residuo_conforme ?? false))>
                                    <label class="form-check-label" for="residuo_conforme">Residuo correspondeu ao anunciado</label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-7">
                                <label class="fs-6 fw-bold form-label">Comentario</label>
                                <textarea name="comentario" class="form-control form-control-solid" rows="3">{{ old('comentario', $avaliacao->comentario ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('avaliacoes.index') }}" class="btn btn-light">Cancelar</a>
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
