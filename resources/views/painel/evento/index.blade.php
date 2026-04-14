@include('layout.header')

<!--begin::Conteúdo-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">

            <div class="card mb-5 mb-xl-5">

                <div class="card-header border-0 pt-2">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Eventos DTEP</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Utilize os campos abaixo para filtrar os eventos</span>
                    </h3>

                    <div class="card-toolbar">
                        <a href="{{ route ('painel.home') }}" class="btn btn-sm btn-light-primary"> Voltar</a>
                    </div>
                </div>

                <div class="card-body">

                    <form class="form" action="{{route('eventos.index')}}" method="post">
                        @csrf
                        <div class="form-group row">

                            <div class="col-lg-4">

                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>Nome do Evento</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" id="nome_evento" name="nome_evento" value="{{$nome_evento }}" />
                            </div>

                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>Categoria</span>
                                </label>
                                <select class="form-control form-control-solid" id="categoria_evento" name="categoria_evento">
                                    <option value="">Selecione</option>
                                    @foreach ($categoria_evento as $categoria_eventos )
                                    <option value="{{ $categoria_eventos->id }}" @if($categoria) @if($categoria==$categoria_eventos->id) selected @endif @endif>{{ $categoria_eventos->nome }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>Situação do Evento</span>
                                </label>
                                <select class="form-control form-control-solid" id="situacao_evento" name="situacao_evento">
                                    <option value="">Selecione</option>
                                    <option @if ($status=='S' ) selected @endif value="S">Ativo</option>
                                    <option @if ($status=='N' ) selected @endif value="N">Inativo</option>
                                </select>
                                </select>
                            </div>

                        </div>
                        <br>
                        <div>
                            <button type="submit" class="btn btn-sm btn-light-primary">Buscar</button>
                            <a href="{{route('eventos.index')}}"> <button type="button" class="btn btn-sm btn-secondary">Limpar</button></a>
                        </div>
                    </form>

                </div>
            </div>

            <!--begin::Tabela-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">

                    <div class="form-group row">

                        <div class="col-lg-12" align="left">

                            <a href="{{route('eventos.create')}}" class="btn btn-sm btn-light-primary">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                                    </svg>
                                </span>
                                Novo Evento</a>
                            <a onclick="exportarExcel()" class="btn btn-sm btn-light-success">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z" />
                                    </svg>
                                </span>
                                Exportar para Excel</a>
                            <a class="btn btn-sm btn-light-danger" onclick="exportarPdf()">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                                        <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z" />
                                    </svg>
                                </span>
                                Exportar para PDF</a>
                        </div>
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        @if (count($evento) <= 0) <div align="center">
                            <br>
                            <p class="fw-bolder"> Nenhum evento cadastrado! </p>
                    </div>
                    @else
                    <table id="tabela" style="font-size: small;
                                    font-weight: 500;" class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 ">
                        <thead>
                            <tr class="fw-bolder text-muted bg-secondary">
                                <th class="min-w-55px rounded-start text-center">Nº</th>
                                <th class="min-w-125px text-center">Evento</th>
                                <th class="min-w-125px text-center">Data</th>
                                <th class="min-w-80px text-center">Status</th>
                                <th class="min-w-100px text-center">Categoria</th>
                                <th class="min-w-80px text-center">Vagas</th>
                                @if(Auth::user()->perfil_id == 2)
                                    <th class="min-w-125px text-center">Público Alvo</th>
                                    <th class="min-w-100px text-end rounded-end" colspan="8"></th>
                                @else
                                    <th class="min-w-125px text-center rounded-end">Público Alvo</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($evento as $eventos )

                            <tr id="tr_">
                                <td align="center">
                                    <a href="{{route('eventos.editar',$eventos->id)}}" style="color:black "> {{$eventos->id}}</a>
                                </td>
                                <td align="center">
                                    <a href="{{route('eventos.editar',$eventos->id)}}" style="color:black  ">{{$eventos->nome_evento}}</a>
                                </td>
                                <td align="center">
                                    <a href="{{route('eventos.editar',$eventos->id)}}" style="color:black ">
                                        {{date('d/m/Y', strtotime($eventos->data_evento))}}
                                    </a>
                                </td>
                                <td align="center">
                                    <a href="{{route('eventos.editar',$eventos->id)}}" style="color:black  ">

                                        @if ($eventos->status_evento == 'S')
                                        Ativo
                                        @else
                                        Inativo
                                        @endif
                                    </a>
                                </td>
                                <td align="center">
                                    <a href="{{route('eventos.editar',$eventos->id)}}" style="color:black ">
                                        {{$eventos->categoria_evento}}
                                    </a>
                                </td>
                                <td align="center">
                                    <a href="{{route('eventos.editar',$eventos->id)}}" style="color:black ">
                                        {{$eventos->vaga_evento}}
                                    </a>
                                </td>

                                <td class="text-center">
                                    <a href="{{route('eventos.editar',$eventos->id)}}" style="color:black ">
                                        {{preg_replace('/,/', ', ', $eventos->publico_alvo)}}
                                    </a>
                                </td>
                                @if(Auth::user()->perfil_id == 2)
                                    <td>
                                        <div class="card-toolbar">
                                            <abbr title="Editar Evento">
                                                <a href="{{route('eventos.editar',$eventos->id)}}" class="btn btn-sm btn btn-primary">

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                                    </svg>

                                                </a>
                                            </abbr>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="card-toolbar">
                                            <abbr title="Programação do Evento">
                                                <a href="{{route('eventos.createProgramacao',$eventos->id)}}" class="btn btn-sm btn btn-primary">

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-week-fill" viewBox="0 0 16 16">
                                                        <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zM9.5 7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm3 0h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zM2 10.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z" />
                                                    </svg>

                                                </a>
                                            </abbr>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="card-toolbar">
                                            <abbr title="Adicionar Documento">
                                                <a href="{{route('eventos.createDocumentoEvento',$eventos->id)}}" class="btn btn-sm btn btn-primary">

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-medical-fill" viewBox="0 0 16 16">
                                                        <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zm-3 2v.634l.549-.317a.5.5 0 1 1 .5.866L7 7l.549.317a.5.5 0 1 1-.5.866L6.5 7.866V8.5a.5.5 0 0 1-1 0v-.634l-.549.317a.5.5 0 1 1-.5-.866L5 7l-.549-.317a.5.5 0 0 1 .5-.866l.549.317V5.5a.5.5 0 1 1 1 0zm-2 4.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1zm0 2h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1z" />
                                                    </svg>

                                                </a>
                                            </abbr>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="card-toolbar">
                                            <abbr title="Relatórios / Listas">
                                                <a href="{{route('eventos.relatorioEventos',$eventos->id)}}" class="btn btn-sm btn btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-line-fill" viewBox="0 0 16 16">
                                                        <path d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2z" />
                                                    </svg>
                                                </a>
                                            </abbr>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="card-toolbar">
                                            <abbr title="Adicionar Participante"> <a href="{{route('eventos.cadastrarParticipanteEvento',$eventos->id)}}" class="btn btn-sm btn btn-info">

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                                                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                                                    </svg> </a></abbr>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="card-toolbar">
                                            <abbr title="Lista de Presença"> <a href="{{route('listaPresenca.index',$eventos->id)}}" class="btn btn-sm btn btn-info">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard2-check-fill" viewBox="0 0 16 16">
                                                        <path d="M10 .5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5.5.5 0 0 1-.5.5.5.5 0 0 0-.5.5V2a.5.5 0 0 0 .5.5h5A.5.5 0 0 0 11 2v-.5a.5.5 0 0 0-.5-.5.5.5 0 0 1-.5-.5Z" />
                                                        <path d="M4.085 1H3.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1h-.585c.055.156.085.325.085.5V2a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 2v-.5c0-.175.03-.344.085-.5Zm6.769 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708Z" />
                                                    </svg> </a></abbr>
                                        </div>
                                    </td>


                                    <td>
                                        <div class="card-toolbar">
                                            <abbr title="Configuração de Certificado"> <a href="{{route('listarCertificado.index', $eventos->id)}}" class="btn btn-sm btn btn-success">
                                                    <i class="bi bi-gear fs-3"></i>
                                                </a></abbr>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="card-toolbar">
                                            <abbr title="Emissão de Certificado">
                                                <a href="{{route('participantes.index', $eventos->id)}}" class="btn btn-sm btn btn-success">

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card-2-front-fill" viewBox="0 0 16 16">
                                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-2zm0 3a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
                                                    </svg>

                                                </a>
                                            </abbr>
                                        </div>
                                    </td>
                                @endif


                            </tr>
                            @endforeach
                            <tr>

                                <td colspan="14" align="center">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="fs-6" colspan="5">@php echo "Total de ".sizeof($evento)." registro(s)." @endphp </div>
                                        {{ $evento->links() }}
                                    </div>

                                </td>
                            </tr>
                        </tbody>


                    </table>
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
@include('painel.evento.js')


<link href="{{ url('assets/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ url('assets/js/datatables.bundle.js') }}"></script>

</body>
<!--end::Body-->

</html>