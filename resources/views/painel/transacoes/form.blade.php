@include('layout.header')
@php $transacao = $transacao ?? null; @endphp

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-fluid">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">{{ $transacao ? 'Editar Transacao' : 'Nova Transacao' }}</span>
                    </h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ $transacao ? route('transacoes.update', $transacao->id) : route('transacoes.store') }}">
                        @csrf
                        @if($transacao) @method('PUT') @endif

                        <div class="row">
                            <div class="col-md-6 mb-7">
                                <label class="required fs-6 fw-bold form-label">Residuo</label>
                                <select name="residuo_id" class="form-select form-select-solid">
                                    <option value="">Selecione</option>
                                    @foreach($residuos as $residuo)
                                        <option value="{{ $residuo->id }}" @selected((string) old('residuo_id', $transacao->residuo_id ?? '') === (string) $residuo->id)>
                                            {{ $residuo->tipo_material }} - {{ optional($residuo->empresa)->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-7">
                                <label class="required fs-6 fw-bold form-label">Empresa origem</label>
                                <select name="empresa_origem_id" class="form-select form-select-solid">
                                    <option value="">Selecione</option>
                                    @foreach($empresas as $empresa)
                                        <option value="{{ $empresa->id }}" @selected((string) old('empresa_origem_id', $transacao->empresa_origem_id ?? '') === (string) $empresa->id)>{{ $empresa->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-7">
                                <label class="required fs-6 fw-bold form-label">Empresa destino</label>
                                <select name="empresa_destino_id" class="form-select form-select-solid">
                                    <option value="">Selecione</option>
                                    @foreach($empresas as $empresa)
                                        <option value="{{ $empresa->id }}" @selected((string) old('empresa_destino_id', $transacao->empresa_destino_id ?? '') === (string) $empresa->id)>{{ $empresa->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-7">
                                <label class="fs-6 fw-bold form-label">Transportadora</label>
                                <select name="empresa_transportadora_id" class="form-select form-select-solid">
                                    <option value="">Sem transportadora</option>
                                    @foreach($empresas as $empresa)
                                        <option value="{{ $empresa->id }}" @selected((string) old('empresa_transportadora_id', $transacao->empresa_transportadora_id ?? '') === (string) $empresa->id)>{{ $empresa->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-7">
                                <label class="required fs-6 fw-bold form-label">Status</label>
                                <select name="status" class="form-select form-select-solid">
                                    @foreach($statusOptions as $status => $label)
                                        <option value="{{ $status }}" @selected(old('status', $transacao->status ?? 'pendente') === $status)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-7">
                                <label class="fs-6 fw-bold form-label">Data transacao</label>
                                <input type="date" name="data_transacao" class="form-control form-control-solid" value="{{ old('data_transacao', optional($transacao->data_transacao ?? null)->format('Y-m-d')) }}">
                            </div>

                            <div class="col-md-3 mb-7">
                                <label class="fs-6 fw-bold form-label">Data recebimento</label>
                                <input type="datetime-local" name="data_recebimento" class="form-control form-control-solid" value="{{ old('data_recebimento', optional($transacao->data_recebimento ?? null)->format('Y-m-d\TH:i')) }}">
                            </div>

                            <div class="col-md-3 mb-7">
                                <label class="fs-6 fw-bold form-label">Codigo rastreio</label>
                                <input type="text" class="form-control form-control-solid" value="{{ $transacao->codigo_rastreio ?? 'Gerado automaticamente' }}" disabled>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('transacoes.index') }}" class="btn btn-light">Cancelar</a>
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
