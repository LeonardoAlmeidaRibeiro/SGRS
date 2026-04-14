@php
use App\Http\Controllers\CertificadoController;
@endphp
@include('layout.header')
<script src="{{ url('assets/ckeditor/build/ckeditor.js') }}"></script>

<!--begin::Conteúdo-->
<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <!--begin::Post-->
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">

            <!--begin::Tabela-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <div class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Tipos de Certificado</span>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{route('eventos.index')}}" class="btn btn-sm btn-light-primary">Voltar</a>
                        &nbsp;
                    </div>
                </div>

                <div class="card-body py-3">
                    <div class="table-responsive">
                        <table id="tabela" class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                            <thead>
                                <tr class="fw-bolder text-muted bg-secondary">
                                    <th class="p-4 min-w-225px rounded-start">Certificado de</th>
                                    <th class="p-4 min-w-225px text-end rounded-end">Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($certificados as $certificado)
                                    <tr >
                                        <td>
                                            <a class="text-dark fw-bolder d-block mb-1 fs-6">
                                                <div>
                                                    <span>{{$certificado->tipo_certificado}}</span>
                                                </div>
                                            </a>
                                        </td>
                                        
                                        <td align="right">
                                            <a href="{{route('editarCertificado.index', $certificado->id)}}">
                                                <button type="button" class="btn btn-sm btn-light-primary">
                                                    <i class="fas fa-solid fa-pen fs-3"></i>Editar
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Tabela-->

            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <div class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Palestrantes</span>
                    </div>
                </div>

                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                            <table id="tabela" class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bolder text-muted bg-secondary">
                                        <th class="p-4 min-w-225px rounded-start">Nome</th>
                                        <th class="p-4 min-w-225px">Editado Em</th>
                                        <th class="p-4 min-w-225px text-end rounded-end">Editar e Visualizar Certificado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dados as $participantes)
                                        
                                        @if($participantes->palestrante == 'S')
                                            <tr>
                                                <td>
                                                    <a class="text-dark fw-bolder d-block mb-1 fs-6">
                                                        <div>
                                                           <input type="hidden" id="texto_verso_palestrante_{{$participantes->inscricao_id}}" value='{{CertificadoController::getPersonalizados($participantes->inscricao_id, 'Palestrante', 'verso')}}'>
                                                            <input type="hidden" id="id_evento" value="{{$participantes->evento_id}}">
                                                            <input type="hidden" id="texto_frente_palestrante_{{$participantes->inscricao_id}}" value='{{CertificadoController::getPersonalizados($participantes->inscricao_id, 'Palestrante', 'frente')}}'>
                                                            <span>{{$participantes->nome_participante}}</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                
                                                <td>
                                                    <div id="Palestrante_editado_em_{{$participantes->inscricao_id}}">
                                                        <a class="text-dark fw-bolder d-block mb-1 fs-6">
                                                            {{CertificadoController::getPersonalizados($participantes->inscricao_id, 'Palestrante', 'updated_at')}}
                                                        </a>
                                                    </div>
                                                </td>
                                                <td align="right">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#certificado_personalizado" class="btn btn-sm btn-light-primary" onclick="AbrirEditar({{$participantes->inscricao_id}}, 'Palestrante')">
                                                        <i class="fas fa-solid fa-pen fs-3"></i>Editar
                                                    </button>

                                                    <a type="button" href="{{ route('previaCertificado.index', 'Palestrante'.'-'.$participantes->evento_id.'-'.$participantes->inscricao_id)}}" target="_blank" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-solid fa-search fs-3"></i>Pré-Visualizar
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
            </div>

            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <div class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Organizadores</span>
                    </div>
                </div>

                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                            <table id="tabela" class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bolder text-muted bg-secondary">
                                        <th class="p-4 min-w-225px rounded-start">Nome</th>
                                        <th class="p-4 min-w-225px">Editado Em</th>
                                        <th class="p-4 min-w-225px text-end rounded-end">Editar e Visualizar Certificado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dados as $participantes)
                                        @if($participantes->org_evento == 'S')
                                            <tr>
                                                <td>
                                                    <a class="text-dark fw-bolder d-block mb-1 fs-6">
                                                        <div>
                                                            <input type="hidden" id="texto_frente_organizador_{{$participantes->inscricao_id}}" value='{{CertificadoController::getPersonalizados($participantes->inscricao_id, 'Organizador do Evento', 'frente')}}'>
                                                            <input type="hidden" id="texto_verso_organizador_{{$participantes->inscricao_id}}" value="{{CertificadoController::getPersonalizados($participantes->inscricao_id, 'Organizador do Evento', 'verso')}}">
                                                            <input type="hidden" id="id_evento" value="{{$participantes->evento_id}}">
                                                            <span>{{$participantes->nome_participante}}</span>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div id="Organizador_editado_em_{{$participantes->inscricao_id}}">
                                                        <a class="text-dark fw-bolder d-block mb-1 fs-6">
                                                            {{CertificadoController::getPersonalizados($participantes->inscricao_id, 'Organizador do Evento', 'updated_at')}}
                                                        </a>
                                                    </div>
                                                </td>
                                                <td align="right">
                                                    <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#certificado_personalizado" onclick="AbrirEditar({{$participantes->inscricao_id}}, 'Organizador do Evento')">
                                                        <i class="fas fa-solid fa-pen fs-3"></i>Editar
                                                    </button>
        
                                                    <a type="button" href="{{ route('previaCertificado.index', 'Organizador do Evento'.'-'.$participantes->evento_id.'-'.$participantes->inscricao_id)}}" target="_blank" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-solid fa-search fs-3"></i>Pré-Visualizar
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
            </div>
        </div>
    </div>
</div>

@include('painel.certificado.editarCertPersonalizado')

@include('layout.footer')

<link href="{{ url('assets/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ url('assets/js/datatables.bundle.js') }}"></script>

@include('painel.certificado.editorJs')


</body>
<!--end::Body-->

</html>