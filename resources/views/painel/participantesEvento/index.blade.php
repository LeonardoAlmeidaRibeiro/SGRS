@include('layout.header')

<!--begin::Conteúdo-->
<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <!--begin::Post-->
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">

            <div class="card mb-xl-8">
                <div class="card-body">

                    <form class="form" action="{{route('participantes.index', $eventos->id)}}" method="get">
                        @csrf
                        <div class="form-group row">

                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>Nome do Participante</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" id="nome_participante" name="nome_participante" />
                            </div>
                        </div>
                        <br>
                        <div>
                            <button type="submit" class="btn btn-sm btn-light-primary">Buscar</button>
                            <a href="{{route('participantes.index', $eventos->id)}}"> <button type="button" class="btn btn-sm btn-secondary">Limpar</button></a>
                        </div>
                    </form>

                </div>
            </div>

            <!--begin::Tabela-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <div class="card-title flex-colum col-11">
                        <div>
                            <span class="card-label fw-bolder fs-3 mb-1" style="width:15%">Participantes do Evento:</span>
                            <input type="hidden" value="{{$eventos->id}}" id="evento_id">
                            <input type="hidden" value="{{$qtd_certificado_evento}}" id="qtd_certificado_evento">
                            <span class="card-label fs-3 mb-1">{{$eventos->nome_evento}}</span>
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <a class="btn btn-sm btn-light-primary" href="{{route('eventos.index')}}">Voltar</a>
                    </div>
                </div>

                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        @if (sizeof($inscricoes) > 0)
                        <table id="tabela" class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bolder text-muted bg-secondary">
                                    <th class="ps-4 min-w-325px rounded-start">Participante</th>
                                    <th class="ps-4 min-w-60px text-center">Data da Inscrição</th>
                                    <th class="ps-4 min-w-60px text-center">Certificado Emitido?</th>
                                    <th class="ps-4 min-w-60px text-center">Presença</th>
                                    @if(Auth::user()->perfil_id == 2)
                                    <th class="ps-4 min-w-125px text-center">Tipo Participação</th>
                                    <th class="ps-4 min-w-425px text-center rounded-end">Certificados</th>
                                    @else
                                    <th class="ps-4 min-w-125px text-center rounded-end">Tipo Participação</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($inscricoes as $inscricao)
                                @if($inscricao->evento_id == $eventos->id)

                                <tr id="tr_{{ $inscricao->id }}">
                                    <td>
                                        <a class="text-dark fw-bolder d-block mb-1 fs-6">
                                            <div id="celula_a_{{ $inscricao->id }}">
                                                {{$inscricao->nome_participante}}
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="text-dark fw-bolder d-block mb-1 fs-6 text-center">
                                            <div id="celula_b_{{ $inscricao->id }}">
                                                {{date('d/m/y', strtotime($inscricao->data_insc))}}
                                            </div>
                                        </a>
                                    </td>
                                    <td id="emitido" align="center">
                                        <a class="text-dark fw-bolder d-block mb-1 fs-6">
                                            <div id="celula_c_{{ $inscricao->id }}">
                                                @if($inscricao->certificado_emitido == 'S')
                                                Sim
                                                @else
                                                Não
                                                @endif
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="text-dark fw-bolder d-block mb-1 fs-6 text-center">
                                            <span>
                                                @if($inscricao->presenca == 'S')
                                                Sim
                                                @else
                                                Não
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="hidden" id="autorizacao" value="{{ $inscricao->id }}" />
                                        <a class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">
                                            <div id="celula_d_{{ $inscricao->id }}" align="left">
                                                @foreach($dados as $dado)

                                                @if($inscricao->id == $dado['id'])
                                                <div class="d-flex flex-column text-dark fw-bolder fs-6 text-center">
                                                    <a>{{$dado['palestrante']}}</a>
                                                    <a>{{$dado['ouvinte']}}</a>
                                                    <a>{{$dado['participante']}}</a>
                                                    <a>{{$dado['org_evento']}}</a>
                                                </div>
                                                @endif
                                                @endforeach
                                            </div>
                                        </a>
                                    </td>
                                    @if(Auth::user()->perfil_id == 2)
                                    @if($eventos->certificado_autorizado == 'S')

                                    @if($inscricao->presenca != 'S')
                                    <td class="text-center">
                                        <div>
                                            <button type="button" class="btn btn-sm btn-danger"><i class="bi bi-person-x fs-2x"></i>Presença Não Confirmada</button>
                                        </div>
                                    </td>
                                    @else
                                    @if(empty($inscricao->certificado_emitido) || $inscricao->certificado_emitido != 'S')
                                    <td id="certificados" class="text-center">
                                        <button type="button" onclick="emitirCertificado('{{$inscricao->id}}')" class="btn btn-sm btn-primary"><i class="fas fa-solid fa-file-import fs-2"></i>Emitir Certificado</button>
                                    </td>
                                    @else
                                    <td>
                                        <div class="d-flex flex-row justify-content-around">

                                            @if($inscricao->participante == 'S' )
                                            <div>
                                                <button type="button" onclick="exportarPdf('Participante','{{ $inscricao->id }}')" class="btn btn-sm btn-primary "><i class="bi bi-file-earmark-arrow-down fs-2x"></i>Participante</button>
                                            </div>
                                            @endif

                                            @if($inscricao->ouvinte == 'S')
                                            <div>
                                                <button type="button" onclick="exportarPdf('Ouvinte','{{ $inscricao->id }}')" class="btn btn-sm btn-primary"><i class="bi bi-file-earmark-arrow-down fs-2x"></i>Ouvinte</button>
                                            </div>
                                            @endif

                                            @if($inscricao->org_evento == 'S')
                                            <div>
                                                <button type="button" onclick="exportarPdf('Organizador do Evento','{{ $inscricao->id }}')" class="btn btn-sm btn-primary"><i class="bi bi-file-earmark-arrow-down fs-2x"></i>Organizador</button>
                                            </div>
                                            @endif

                                            @if($inscricao->palestrante == 'S')
                                            <div>
                                                <button type="button" onclick="exportarPdf('Palestrante','{{ $inscricao->id }}')" class="btn btn-sm btn-primary"><i class="bi bi-file-earmark-arrow-down fs-2x"></i>Palestrante</button>
                                            </div>
                                            @endif
                                            <div>
                                              
                                                <button type="button" onclick="excluirCertificado('{{ $inscricao->id_participante }}', '{{ $eventos->id }}', '{{ $inscricao->id }}')" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-file-x fs-2x"></i>Excluir Certificado
                                                </button>
                                               
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                    @endif
                                    @else
                                    <td class="text-center">
                                        <div>
                                            <button type="button" class="btn btn-sm btn-danger"><i class="bi bi-file-earmark-excel fs-2x"></i>Certificado Não Autorizado</button>
                                        </div>
                                    </td>
                                    @endif
                                    @endif
                                </tr>
                                @endif
                                @endforeach

                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                        @else
                        <div align="center">
                            <br>
                            <p class="fw-bolder"> Nenhum participante cadastrado para esse evento </p>
                        </div>
                        @endif
                    </div>
                    <!--end::Table container-->
                </div>
                <!--begin::Body-->
            </div>
            <!--end::Tabela-->


        </div>
    </div>
</div>


@include('layout.footer')

<link href="{{ url('assets/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ url('assets/js/datatables.bundle.js') }}"></script>

@include('painel.participantesEvento.js')

</body>
<!--end::Body-->

</html>
