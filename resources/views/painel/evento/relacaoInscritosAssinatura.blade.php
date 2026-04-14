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
                    <div class="card-title flex-column col-8 ">
                        <div>
                            <span class="card-label fw-bolder fs-3 mb-1" style="width:20%">Relação de Presença (Assinatura):</span>
                            <span class="card-label fs-3 mb-1">{{$eventos->nome_evento}}</span>
                        </div>
                    </div>

                    <div class="card-toolbar">
                        @if (sizeof($inscritos))
                        <div class="p-2">
                            <a class="btn btn-sm btn-light-danger" onclick="exportarPdf({{$eventos->id}})">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                                        <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z" />
                                    </svg>
                                </span>
                                Exportar para PDF
                            </a>
                        </div>

                        <div class="p-2">
                            <a onclick="exportarExcel({{$eventos->id}})" class="btn btn-sm btn-light-success">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z" />
                                    </svg>
                                </span>
                                Exportar para Excel
                            </a>
                        </div>
                        @endif
                        <div class="p-2">
                            <a href="{{route('eventos.relatorioEventos',$eventos->id)}}" class="btn btn-sm btn-light-primary">
                                Voltar
                            </a>
                        </div>

                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    @if (sizeof($inscritos)>0)
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table id="tabela" class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bolder text-muted bg-secondary">
                                    <th class="ps-4 min-w-325px rounded-start">Nome</th>
                                    <th class="ps-4 min-w-325px">Tipo Participação</th>
                                    <th class="min-w-200px text-center rounded-end">Assinatura</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>


                                @foreach ( $inscritos as $inscrito )
                                <tr id="tr_{{-- $categoria_eventos->id --}}">

                                    <td>
                                        <a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">

                                            <div>{{$inscrito->nome}}</div>
                                        </a>
                                    </td>

                                    <td>
                                        <a href="#" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">

                                            <div>
                                                @php $opcoes_selecionadas = array(); @endphp
                                                @if ( $inscrito->participante == 'S')
                                                @php $opcoes_selecionadas[] = 'Participante'; @endphp
                                                @endif

                                                @if ( $inscrito->palestrante == 'S')
                                                @php $opcoes_selecionadas[] = 'Palestrante'; @endphp
                                                @endif

                                                @if ( $inscrito->org_evento == 'S')
                                                @php $opcoes_selecionadas[] = 'Organizador'; @endphp
                                                @endif

                                                @if ( $inscrito->ouvinte == 'S')
                                                @php $opcoes_selecionadas[] = 'Ouvinte'; @endphp
                                                @endif
                                                {{ implode(', ', $opcoes_selecionadas) }}
                                            </div>
                                        </a>
                                    </td>

                                    <td>

                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>

                    @else
                    <br>
                    <div class="d-flex justify-content-center">
                        <div class="fs-6" colspan="5">
                            <p class="fw-bolder">@php echo "Nenhum participante cadastrado no evento." @endphp </p>
                        </div>
                    </div>
                    @endif
                    <!--end::Table container-->

                </div>
                <!--end::Tabela-->


            </div>
        </div>
    </div>


    @include('layout.footer')

    <link href="{{ url('assets/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ url('assets/js/datatables.bundle.js') }}"></script>

    @include('painel.listaPresenca.js')
    <script>
        $("#tabela").DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros",
            },
            "dom": "<'row'" +
                "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">"
        });
    </script>

    </body>
    <!--end::Body-->

    </html>