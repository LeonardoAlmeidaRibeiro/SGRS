@include('layout.header')

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-fluid">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">{{ $empresa->nome }}</span>
                        <span class="text-muted mt-1 fw-bold fs-7">{{ $empresa->cidade }}/{{ $empresa->estado }} - {{ $empresa->cnpj }}</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn btn-sm btn-light-primary">Editar</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-8">
                        <div class="col-md-3 mb-5"><div class="text-muted fw-bold">Reputacao</div><div class="fs-4">{{ number_format((float) $empresa->reputacao_media, 1, ',', '.') }}</div></div>
                        <div class="col-md-3 mb-5"><div class="text-muted fw-bold">Taxa de conformidade</div><div class="fs-4">{{ number_format((float) $empresa->taxa_conformidade, 0, ',', '.') }}%</div></div>
                        <div class="col-md-3 mb-5"><div class="text-muted fw-bold">Licenca perigoso</div><div class="fs-5">{{ $empresa->podeReceberResiduoPerigoso() ? 'Sim' : 'Nao' }}</div></div>
                        <div class="col-md-3 mb-5"><div class="text-muted fw-bold">Restricao</div><div class="fs-5">{{ $empresa->restrita_por_reputacao ? 'Reputacao baixa' : 'Sem restricao' }}</div></div>
                    </div>

                    <div class="separator my-8"></div>
                    <h4 class="fw-bolder mb-5">Conformidade legal</h4>
                    <div class="row mb-8">
                        <div class="col-md-3 mb-5">
                            <div class="text-muted fw-bold">Licenca ambiental</div>
                            <div class="fs-5">
                                @if($empresa->possui_licenca_ambiental)
                                    <span class="badge badge-success">Possui</span>
                                @else
                                    <span class="badge badge-light-danger">Nao informada</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <div class="text-muted fw-bold">Residuos perigosos</div>
                            <div class="fs-5">
                                @if($empresa->licenca_residuos_perigosos)
                                    <span class="badge badge-success">Autorizada</span>
                                @else
                                    <span class="badge badge-light-warning">Nao autorizada</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <div class="text-muted fw-bold">Numero da licenca</div>
                            <div class="fs-5">{{ $empresa->numero_licenca_ambiental ?: '-' }}</div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <div class="text-muted fw-bold">Validade</div>
                            <div class="fs-5">
                                {{ optional($empresa->validade_licenca_ambiental)->format('d/m/Y') ?: '-' }}
                                @if($empresa->validade_licenca_ambiental && $empresa->validade_licenca_ambiental->isPast())
                                    <span class="badge badge-light-danger ms-2">Vencida</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mb-5">
                            <div class="text-muted fw-bold">Arquivo da licenca</div>
                            <div class="fs-5">
                                @if($empresa->licenca_ambiental_url)
                                    <a href="{{ $empresa->licenca_ambiental_url }}" target="_blank" class="btn btn-sm btn-light-info">Abrir documento</a>
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="separator my-8"></div>
                    <h4 class="fw-bolder mb-5">Funcionarios</h4>
                    <form method="POST" action="{{ route('empresas.funcionarios.store', $empresa->id) }}" class="mb-6">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 mb-4"><input name="name" class="form-control form-control-solid" placeholder="Nome"></div>
                            <div class="col-md-3 mb-4"><input name="email" type="email" class="form-control form-control-solid" placeholder="E-mail"></div>
                            <div class="col-md-2 mb-4"><input name="password" type="password" class="form-control form-control-solid" placeholder="Senha"></div>
                            <div class="col-md-2 mb-4"><select name="perfil" class="form-select form-select-solid"><option value="operador">Operador</option><option value="admin">Administrador</option><option value="comprador">Comprador</option><option value="auditor">Auditor</option></select></div>
                            <div class="col-md-2 mb-4"><button class="btn btn-primary w-100">Adicionar</button></div>
                        </div>
                    </form>

                    <div class="table-responsive mb-8">
                        <table class="table table-row-bordered align-middle gs-0 gy-3">
                            <thead><tr class="fw-bolder text-muted bg-secondary"><th class="ps-4">Nome</th><th>E-mail</th><th>Perfil</th><th class="text-end pe-4">Acoes</th></tr></thead>
                            <tbody>
                                @foreach($empresa->usuarios as $usuario)
                                    <tr>
                                        <td class="ps-4">{{ $usuario->name }}</td>
                                        <td>{{ $usuario->email }}</td>
                                        <td>{{ ucfirst($usuario->perfil) }}</td>
                                        <td class="text-end pe-4">
                                            <form method="POST" action="{{ route('empresas.funcionarios.destroy', [$empresa->id, $usuario->id]) }}" class="d-inline form-excluir">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-light-danger">Remover</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end"><a href="{{ route('empresas.index') }}" class="btn btn-light">Voltar</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout.footer')
<script>
$('.form-excluir').on('submit', function(e) {
    e.preventDefault();
    var form = this;
    Swal.fire({ title: 'Remover funcionario?', icon: 'warning', showCancelButton: true, cancelButtonText: 'Cancelar', confirmButtonText: 'Sim, remover' }).then(function(r) {
        if (r.isConfirmed || r.value) form.submit();
    });
});
</script>
@include('painel.shared.alerts')
</body>
</html>
