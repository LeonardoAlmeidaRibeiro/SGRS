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

    <div class="col-md-3 mb-7">
        <label class="fs-6 fw-bold form-label mb-2">CEP</label>
        <input type="text" class="form-control form-control-solid" name="cep" maxlength="9" placeholder="00000-000" value="{{ old('cep', $residuo->cep ?? '') }}">
        <div class="text-muted fs-8 mt-1" data-cep-status></div>
    </div>

    <div class="col-md-5 mb-7">
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
    <div class="col-md-12 mb-4">
        <div class="separator separator-dashed my-4"></div>
        <h4 class="fw-bolder mb-1">Validacao legal e logistica</h4>
        <div class="text-muted fs-7">Para o residuo aparecer no marketplace, anexe MTR ou licenca ambiental e conclua o checklist com assinatura digital.</div>
    </div>

    <div class="col-md-6 mb-7">
        <label class="fs-6 fw-bold form-label mb-2">MTR</label>
        <input type="file" class="form-control form-control-solid" name="mtr_arquivo" accept=".pdf,.jpg,.jpeg,.png">
        @if($residuo && $residuo->mtr_url)
            <a href="{{ $residuo->mtr_url }}" target="_blank" class="fs-7 mt-2 d-inline-block">Ver MTR anexado</a>
        @endif
    </div>

    <div class="col-md-6 mb-7">
        <label class="fs-6 fw-bold form-label mb-2">Licenca ambiental</label>
        <input type="file" class="form-control form-control-solid" name="licenca_ambiental_arquivo" accept=".pdf,.jpg,.jpeg,.png">
        @if($residuo && $residuo->licenca_ambiental_url)
            <a href="{{ $residuo->licenca_ambiental_url }}" target="_blank" class="fs-7 mt-2 d-inline-block">Ver licenca anexada</a>
        @endif
    </div>

    <div class="col-md-3 mb-7">
        <div class="form-check form-check-custom form-check-solid">
            <input class="form-check-input" type="checkbox" name="checklist_origem_preenchido" value="1" id="checklist_origem_preenchido" @checked(old('checklist_origem_preenchido', $residuo->checklist_origem_preenchido ?? false))>
            <label class="form-check-label" for="checklist_origem_preenchido">Origem preenchida</label>
        </div>
    </div>

    <div class="col-md-3 mb-7">
        <div class="form-check form-check-custom form-check-solid">
            <input class="form-check-input" type="checkbox" name="checklist_quantidade_confirmada" value="1" id="checklist_quantidade_confirmada" @checked(old('checklist_quantidade_confirmada', $residuo->checklist_quantidade_confirmada ?? false))>
            <label class="form-check-label" for="checklist_quantidade_confirmada">Quantidade confirmada</label>
        </div>
    </div>

    <div class="col-md-3 mb-7">
        <div class="form-check form-check-custom form-check-solid">
            <input class="form-check-input" type="checkbox" name="checklist_acondicionamento_confirmado" value="1" id="checklist_acondicionamento_confirmado" @checked(old('checklist_acondicionamento_confirmado', $residuo->checklist_acondicionamento_confirmado ?? false))>
            <label class="form-check-label" for="checklist_acondicionamento_confirmado">Acondicionamento conferido</label>
        </div>
    </div>

    <div class="col-md-3 mb-7">
        <div class="form-check form-check-custom form-check-solid">
            <input class="form-check-input" type="checkbox" name="checklist_documentos_conferidos" value="1" id="checklist_documentos_conferidos" @checked(old('checklist_documentos_conferidos', $residuo->checklist_documentos_conferidos ?? false))>
            <label class="form-check-label" for="checklist_documentos_conferidos">Documentos conferidos</label>
        </div>
    </div>

    <div class="col-md-12 mb-7">
        <label class="fs-6 fw-bold form-label mb-2">Assinatura digital do responsavel</label>
        <input type="text" class="form-control form-control-solid" name="assinatura_digital" value="{{ old('assinatura_digital', $residuo->assinatura_digital ?? '') }}" placeholder="Nome completo, CPF ou identificador digital">
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var cepInput = document.querySelector('[name="cep"]');
        var enderecoInput = document.querySelector('[name="endereco"]');
        var cidadeInput = document.querySelector('[name="cidade"]');
        var estadoInput = document.querySelector('[name="estado"]');
        var latitudeInput = document.querySelector('[name="latitude"]');
        var longitudeInput = document.querySelector('[name="longitude"]');
        var statusEl = document.querySelector('[data-cep-status]');

        if (!cepInput || !enderecoInput || !cidadeInput || !estadoInput || !latitudeInput || !longitudeInput) {
            return;
        }

        function setStatus(message) {
            if (statusEl) {
                statusEl.textContent = message || '';
            }
        }

        function aplicarMascaraCep(value) {
            var numeros = value.replace(/\D/g, '').slice(0, 8);
            return numeros.length > 5 ? numeros.slice(0, 5) + '-' + numeros.slice(5) : numeros;
        }

        function montarBusca() {
            return [
                enderecoInput.value,
                cidadeInput.value,
                estadoInput.value,
                cepInput.value,
                'Brasil'
            ].filter(Boolean).join(', ');
        }

        function buscarCoordenadas() {
            var busca = montarBusca();

            if (!busca || (latitudeInput.value && longitudeInput.value)) {
                return Promise.resolve();
            }

            setStatus('Buscando latitude e longitude...');

            return fetch('https://nominatim.openstreetmap.org/search?format=json&limit=1&countrycodes=br&q=' + encodeURIComponent(busca))
                .then(function (response) {
                    return response.ok ? response.json() : [];
                })
                .then(function (data) {
                    if (data && data.length) {
                        latitudeInput.value = data[0].lat;
                        longitudeInput.value = data[0].lon;
                        setStatus('Coordenadas preenchidas automaticamente.');
                    } else {
                        setStatus('Nao foi possivel encontrar as coordenadas. Confira o endereco.');
                    }
                })
                .catch(function () {
                    setStatus('Nao foi possivel buscar as coordenadas agora.');
                });
        }

        function buscarCep() {
            var cep = cepInput.value.replace(/\D/g, '');

            if (cep.length !== 8) {
                setStatus('');
                return;
            }

            setStatus('Buscando endereco pelo CEP...');

            fetch('https://viacep.com.br/ws/' + cep + '/json/')
                .then(function (response) {
                    return response.ok ? response.json() : null;
                })
                .then(function (data) {
                    if (!data || data.erro) {
                        setStatus('CEP nao encontrado.');
                        return;
                    }

                    if (!enderecoInput.value && data.logradouro) {
                        enderecoInput.value = data.logradouro;
                    }

                    if (!cidadeInput.value && data.localidade) {
                        cidadeInput.value = data.localidade;
                    }

                    if (!estadoInput.value && data.uf) {
                        estadoInput.value = data.uf;
                    }

                    buscarCoordenadas();
                })
                .catch(function () {
                    setStatus('Nao foi possivel buscar o CEP agora.');
                });
        }

        cepInput.addEventListener('input', function () {
            cepInput.value = aplicarMascaraCep(cepInput.value);
        });

        cepInput.addEventListener('blur', buscarCep);
        enderecoInput.addEventListener('blur', buscarCoordenadas);
        cidadeInput.addEventListener('blur', buscarCoordenadas);
        estadoInput.addEventListener('blur', buscarCoordenadas);
    });
</script>
