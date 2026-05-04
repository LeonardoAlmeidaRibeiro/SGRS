@php
    $residuo = $residuo ?? null;
    $empresaSelecionada = old('empresa_id', $residuo->empresa_id ?? optional(Auth::user())->empresa_id);
    $statusSelecionado = old('status', $residuo->status ?? 'disponivel');
@endphp

<div class="row">
    <div class="col-md-6 mb-7">
        <label class="required fs-6 fw-bold form-label mb-2">Empresa</label>
        <select class="form-select form-select-solid" name="empresa_id">
            <option value="">Selecione</option>
            @foreach ($empresas as $empresa)
                <option value="{{ $empresa->id }}" @selected((string) $empresaSelecionada === (string) $empresa->id)>
                    {{ $empresa->nome }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-7">
        <label class="required fs-6 fw-bold form-label mb-2">Classificação</label>
        <select class="form-select form-select-solid" name="classificacao_id">
            <option value="">Selecione</option>
            @foreach ($classificacoes as $classificacao)
                <option value="{{ $classificacao->id }}" @selected((string) old('classificacao_id', $residuo->classificacao_id ?? '') === (string) $classificacao->id)>
                    {{ $classificacao->nome }} - {{ $classificacao->codigo }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-7">
        <label class="required fs-6 fw-bold form-label mb-2">Tipo de material</label>
        <input type="text" class="form-control form-control-solid" name="tipo_material" value="{{ old('tipo_material', $residuo->tipo_material ?? '') }}">
    </div>

    <div class="col-md-6 mb-7">
        <label class="fs-6 fw-bold form-label mb-2">Imagem</label>
        <input type="url" class="form-control form-control-solid" name="imagem" placeholder="https://..." value="{{ old('imagem', $residuo->imagem ?? '') }}">
    </div>

    <div class="col-md-3 mb-7">
        <label class="required fs-6 fw-bold form-label mb-2">Quantidade</label>
        <input type="number" class="form-control form-control-solid" name="quantidade" step="0.001" min="0" value="{{ old('quantidade', $residuo->quantidade ?? '') }}">
    </div>

    <div class="col-md-3 mb-7">
        <label class="required fs-6 fw-bold form-label mb-2">Unidade</label>
        <select class="form-select form-select-solid" name="unidade_id">
            <option value="">Selecione</option>
            @foreach ($unidades as $unidade)
                <option value="{{ $unidade->id }}" @selected((string) old('unidade_id', $residuo->unidade_id ?? '') === (string) $unidade->id)>
                    {{ $unidade->nome }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 mb-7">
        <label class="required fs-6 fw-bold form-label mb-2">Status</label>
        <select class="form-select form-select-solid" name="status">
            @foreach ($statusOptions as $status => $label)
                <option value="{{ $status }}" @selected($statusSelecionado === $status)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-8 mb-7">
        <label class="required fs-6 fw-bold form-label mb-2">Endereço</label>
        <input type="text" class="form-control form-control-solid" name="endereco" value="{{ old('endereco', $residuo->endereco ?? '') }}">
    </div>

    <div class="col-md-5 mb-7">
        <label class="required fs-6 fw-bold form-label mb-2">Cidade</label>
        <input type="text" class="form-control form-control-solid" name="cidade" value="{{ old('cidade', $residuo->cidade ?? '') }}">
    </div>

    <div class="col-md-2 mb-7">
        <label class="required fs-6 fw-bold form-label mb-2">UF</label>
        <input type="text" class="form-control form-control-solid text-uppercase" name="estado" maxlength="2" value="{{ old('estado', $residuo->estado ?? '') }}">
    </div>

    <div class="col-md-2 mb-7">
        <label class="fs-6 fw-bold form-label mb-2">Latitude</label>
        <input type="number" class="form-control form-control-solid" name="latitude" step="0.0000001" value="{{ old('latitude', $residuo->latitude ?? '') }}">
    </div>

    <div class="col-md-3 mb-7">
        <label class="fs-6 fw-bold form-label mb-2">Longitude</label>
        <input type="number" class="form-control form-control-solid" name="longitude" step="0.0000001" value="{{ old('longitude', $residuo->longitude ?? '') }}">
    </div>

    <div class="col-md-12 mb-7">
        <label class="fs-6 fw-bold form-label mb-2">Descrição</label>
        <textarea class="form-control form-control-solid" name="descricao" rows="4">{{ old('descricao', $residuo->descricao ?? '') }}</textarea>
    </div>
</div>
