@include('layout.header')

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
                    <div class="card-title flex-column col-11 ">
                        <div>
                            <span class="card-label fw-bolder fs-3 mb-1" style="width:20%">Participantes do Evento:</span>
                            <span class="card-label fs-3 mb-1">{{$eventos->nome_evento}}</span>
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <a class="btn btn-sm btn-light-primary text-right" href="{{route('eventos.index')}}">Voltar</a>
                    </div>

                </div>

                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <div class="d-flex flex-row-reverse">
                        @if (count($consultaEstudante) > 0)
                        <a class="btn btn-sm btn-success" onclick="listageral('{{$eventos->id}}')">Marcar todos presentes</a>
                        @endif
                    </div>
                    <br>

                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        @if (count($consultaEstudante) > 0)
                        <table id="tabela" class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bolder text-muted bg-secondary">
                                    <th class="ps-4 min-w-125px rounded-start">Participantes</th>
                                    <th class="ps-4 min-w-125px">Tipo Participação</th>
                                    <th class="ps-4 min-w-2px text-end rounded-end">Presença&nbsp;&nbsp;</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>

                                @foreach ($consultaEstudante as $inscricao)
                                @if($inscricao->evento_id == $eventos->id)
                                <tr id="tr_{{ $inscricao->id }}">
                                    <td>
                                        <a class="text-dark fw-bolder d-block mb-1 fs-6">
                                            <div id="celula_a_{{ $inscricao->id }}">
                                                {{$inscricao->nome}}
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <input type="hidden" id="autorizacao" value="{{ $inscricao->id }}" />
                                        <a class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">
                                            <div id="celula_b_{{ $inscricao->id }}" align="left">
                                                @foreach($dados as $dado)

                                                @php $opcoes_selecionadas = array(); @endphp
                                                @if($inscricao->id == $dado['id'])
                                                <div class="d-flex flex-column text-dark fw-bolder fs-6">
                                                    @if ($dado['palestrante'])@php $opcoes_selecionadas[] = 'Palestrante'; @endphp @endif
                                                    @if($dado['ouvinte'] )@php $opcoes_selecionadas[] = 'Ouvinte'; @endphp @endif
                                                    @if($dado['participante'])@php $opcoes_selecionadas[] = 'Participante'; @endphp @endif
                                                    @if($dado['org_evento'])@php $opcoes_selecionadas[] = 'Organizador'; @endphp @endif
                                                    <a>{{ implode(', ', $opcoes_selecionadas) }}</a>
                                                </div>
                                                @endif
                                                @endforeach
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="">
                                            <div class="form-check form-switch form-check-custom form-check-success form-check-solid d-flex justify-content-end">
                                                <input class="form-check-input" onclick="listaPresenca('{{$inscricao->id}}')" type="checkbox" id="presenca_{{$inscricao->id}}" @if($inscricao->presenca == 'S') checked="checked" @endif />&nbsp;&nbsp;
                                            </div>
                                        </div>

                                    </td>
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

@include('painel.listaPresenca.js')

</body>
<!--end::Body-->

</html>