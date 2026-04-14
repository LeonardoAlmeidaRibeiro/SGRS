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
                    <h3 class="card-title align-items-start flex-row">
                        <span class="card-label fw-bolder fs-3 mb-1">Autorizar Certificados</span>
                    </h3>
                    
                    <div class="card-toolbar">
                        <a href="{{ route ('painel.home') }}" class="btn btn-sm btn-light-primary"> Voltar</a>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table id="tabela" class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bolder text-muted bg-secondary">
                                    <th class="ps-4 min-w-225px rounded-start">Nome</th>
                                    <th class="ps-4 min-w-80px" style="text-align: center">Categoria</th>
                                    <th class="ps-4 min-w-80px" style="text-align: center">Participantes</th>
                                    <th class="ps-4 min-w-125px" style="text-align: center">Data</th>
                                    <th class="ps-4 min-w-125px" style="text-align: center">Autorizado?</th>
                                    <th class="ps-4 min-w-125px" style="text-align: center">Autorizado Em</th>
                                    <th class="ps-4 min-w-325px rounded-end" style="text-align: center">Ações</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>

                                @foreach ($eventos as $evento)
                                <tr id="tr_{{ $evento->id }}">
                                    <td>
                                        <a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">
                                            <div id="celula_a_{{ $evento->id }}">
                                                {{ $evento->nome_evento }}
                                            </div>
                                        </a>
                                    </td>
                                    <td>

                                        <a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">
                                            <div id="celula_b_{{ $evento->id }}" align="center">
                                                {{ $evento->categoriaEvento()->first()->nome }}
                                            </div>
                                        </a>
                                    </td>
                                    <td>

                                        <a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">
                                            <div id="celula_c_{{ $evento->id }}" align="center">
                                                @foreach($dados as $qtd_partic)

                                                @if($evento->id == $qtd_partic['evento_id'])
                                                {{$qtd_partic['qtd_participantes']}}
                                                @endif
                                                @endforeach
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                    <input type="hidden" id="data_evento{{ $evento->id }}" value="{{$evento->data_evento}}" />
                                        <a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">
                                            <div id="celula_d_{{ $evento->id }}" align="center">
                                                {{ date("d/m/y", strtotime($evento->data_evento)) }}
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <input type="hidden" id="autorizacao{{ $evento->id }}" value="{{$evento->certificado_autorizado}}" />
                                        <a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">
                                            <div id="celula_e_{{ $evento->id }}" align="center">
                                                @if($evento->certificado_autorizado == 'S' and $evento->certificado_autorizado != null)
                                                Sim
                                                @else
                                                Não
                                                @endif
                                            </div>
                                        </a>
                                    </td>
                                    <td>

                                        <a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">
                                            <div id="celula_f_{{ $evento->id }}" align="center">
                                                @if(isset($evento->autorizado_em) and $evento->autorizado_em != null)
                                                {{ date("d/m/Y", strtotime($evento->autorizado_em)) }}
                                                @else
                                                -
                                                @endif
                                            </div>
                                        </a>
                                    </td>
                                    <td id="botao_acoes_{{ $evento->id }}" align="center">
                                        <div class="card-toolbar">
                                            @if($evento->certificado_autorizado == 'S')
                                            <a class="btn btn-sm btn-light-Danger" onclick="Autorizar('{{$evento->id}}')">
                                                <!-- icone -->
                                                <i class="fas fa-duotone fa-lock-open fs-1"></i>
                                                Cancelar
                                            </a>
                                            @else
                                            <a class="btn btn-sm btn-light-success" onclick="Autorizar('{{$evento->id}}')">
                                                <!-- icone -->
                                                <i class="fas fa-duotone fa-lock fs-1"></i>
                                                Autorizar
                                            </a>
                                            @endif
                                            <a href="{{ route('participantes.index', $evento->id)}}" class="btn btn-sm btn-light-primary">
                                                <i class="fas fa-duotone fa-users fs-1"></i>
                                                Participantes
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                                @endforeach

                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
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

@include('painel.autorizarCertificado.js')

</body>
<!--end::Body-->

</html>