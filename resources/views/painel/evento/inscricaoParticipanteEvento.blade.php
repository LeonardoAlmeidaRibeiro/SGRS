@include('layout.header')
<style>
    .dropdown-menu {
        will-change: none !important;
        transform: none !important;
        max-width: 500px !important;
    }

    .filter-option-inner {

        position: relative !important;
        bottom: 0.3rem !important;
    }

    .filter-option {
        height: 3.3rem !important;
        border-radius: 8px;
        padding: 1rem !important;
        border-color: #f5f8fa;
        color: #5e6278;
        transition: color .2s ease, background-color .2s ease;
    }

    .dropdown-toggle,
    .btn-light {
        height: 3.3rem !important;
        border-radius: 8px;
        transition: color .2s ease, background-color .2s ease;
    }


    .disabled-link {
        pointer-events: none;
    }
</style>

<!--begin::Conteúdo-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">

            <div class="card mb-5 mb-xl-5">

                <div class="card-header border-0 pt-2">
                    <div class="card-title flex-column col-11">
                        <div>
                            <span class="card-label fw-bolder fs-3 mb-1" style="width: 20%;">Adicionar Participantes:</span>
                            <span class="card-label fs-3 mb-1 ">{{$evento->nome_evento}}</span>
                        </div>
                        <div>
                            <span class="text-muted mt-1 fw-bold fs-7">Utilize os campos abaixo para adicionar participantes</span>
                        </div>
                    </div>

                    <div class="card-toolbar">
                        <a class="btn btn-sm btn-light-primary" href="{{route('eventos.index')}}"> Voltar</a>
                    </div>
                </div>

                <div class="card-body">

                    <form class="form" action="#" method="post">
                        <div class="form-group row">
                            <input type="hidden" id="evento_id" name="evento_id" value="{{$evento->id}}">

                            <div class="col-lg-6">

                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class='required'>Nome</span>
                                </label>
                                <select data-live-search="true" data-live-search-style="startsWith" class="form-control form-control-solid selectpicker" id="participante_id" name="participante_id" required>
                                    <option value="">Selecione</option>
                                    @foreach ($participante as $participantes )
                                    <option value="{{$participantes->id}}">{{$participantes->nome}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class='required'>Forma de Conhecimento do evento</span>
                                </label>
                                <select class="form-control form-control-solid" id="conhecimento_evento_id" name="conhecimento_evento_id" required>
                                    <option value="">Selecione</option>
                                    @foreach ($forma_conhecimento as $forma_conhecimentos )
                                    <option value="{{$forma_conhecimentos->id}}">{{$forma_conhecimentos->nome}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-lg-3">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class='required'>Forma de Inscrição</span>
                                </label>
                                <select class="form-control form-control-solid" id="forma_inscricao_id" name="forma_inscricao_id" required>
                                    <option value="">Selecione</option>
                                    @foreach ( $forma_inscricao as $forma_inscricaos )
                                    <option value="{{$forma_inscricaos->id}}">{{$forma_inscricaos->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class='required'>Participante</span>
                                </label>
                                <select class="form-control form-control-solid" id="participante" name="participante" required>
                                    <option value="">Selecione</option>
                                    <option value="S">Sim</option>
                                    <option value="N">Não</option>
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class='required'>Palestrante</span>
                                </label>
                                <select class="form-control form-control-solid" id="palestrante" name="palestrante" required>
                                    <option value="">Selecione</option>
                                    <option value="S">Sim</option>
                                    <option value="N">Não</option>
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class='required'>Organizador do Evento</span>
                                </label>
                                <select class="form-control form-control-solid" id="org_evento" name="org_evento" required>
                                    <option value="">Selecione</option>
                                    <option value="S">Sim</option>
                                    <option value="N">Não</option>
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class='required'>Ouvinte</span>
                                </label>
                                <select class="form-control form-control-solid" id="ouvinte" name="ouvinte" required>
                                    <option value="">Selecione</option>
                                    <option value="S">Sim</option>
                                    <option value="N">Não</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div>
                            <button type="button" class="btn btn-sm btn-light-primary" onclick="cadastrarParticipanteEvento()">Salvar</button>
                        </div>
                    </form>

                </div>
            </div>

            <!--begin::Tabela-->
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">

                    <div class="form-group row">
                        <div class="form-group row">
                            <span class="card-label fw-bolder fs-5 mb-1">Lista de Participantes</span>
                        </div>
                        <br><br>

                        <div class="col-lg-12" align="left">

                            @if (sizeof($inscrito)>0)
                            <a onclick="exportarExcelInscristos()" class="btn btn-sm btn-light-success">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z" />
                                    </svg>
                                </span>
                                Exportar para Excel</a>
                            <a class="btn btn-sm btn-light-danger" onclick="exportarPdfInscristos()">
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


                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table id="tabela" style="font-size: small;
                            font-weight: 500;" class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 ">
                            <thead>
                                <tr class="fw-bolder text-muted bg-secondary">
                                    <th style="width:39%" class="ps-3 min-w-10px rounded-start">Nome</th>
                                    <th style="width:8%; text-align: center;">Inscrição em</th>
                                    <th style="width:8%; text-align: center;">Conhecimeto</th>
                                    <th style="width:8%; text-align: center;">Inscrição</th>
                                    <th style="width:8%; text-align: center;">Participante?</th>
                                    <th style="width:8%; text-align: center;">Palestrante?</th>
                                    <th style="width:8%; text-align: center;">Organizador?</th>
                                    <th style="width:8%; text-align: center;">Ouvinte?</th>
                                    <th style="width:5%" class="min-w-100px text-end rounded-end" style="padding-right: 13%; text-align: right;" colspan="2"></th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ( $inscrito as $inscritos )
                                <tr id="tr_{{ $inscritos->id }}">
                                    <td align="left">
                                        <div id="celula_a_{{ $inscritos->id }}"> &nbsp; {{$inscritos->nome ?? 'Nome não encontrado'}}</div>
                                    </td>
                                    <td align="center">
                                        <div id="celula_h_{{ $inscritos->id }}"> {{date('d/m/Y', strtotime($inscritos->created_at))}}</div>
                                    </td>
                                    <td align="center">
                                        <input type="hidden" id="conhecimento_evento_nome_valor_{{ $inscritos->id  }}" value="{{ $inscritos->conhecimento_evento_nome_id }}" />
                                        <div id="celula_b_{{ $inscritos->id }}"> {{$inscritos->conhecimento_evento_nome}}</div>
                                    </td>
                                    <td align="center">
                                        <input type="hidden" id="forma_inscricao_nome_valor_{{ $inscritos->id  }}" value="{{ $inscritos->forma_inscricao_nome_id }}" />
                                        <div id="celula_c_{{ $inscritos->id }}"> {{$inscritos->forma_inscricao_nome}}</div>
                                    </td>
                                    <td align="center">
                                        <input type="hidden" id="participante_valor_{{ $inscritos->id  }}" value="{{ $inscritos->participante }}" />
                                        <div id="celula_d_{{ $inscritos->id }}" value="{{$inscritos->participante }}">
                                            @if ( $inscritos->participante == 'S') Sim @else Não @endif
                                        </div>
                                    </td>
                                    <td align="center">
                                        <input type="hidden" id="palestrante_valor_{{ $inscritos->id  }}" value="{{ $inscritos->palestrante }}" />
                                        <div id="celula_e_{{ $inscritos->id }}">
                                            @if ( $inscritos->palestrante == 'S') Sim @else Não @endif
                                        </div>
                                    </td>
                                    <td align="center">
                                        <input type="hidden" id="organizador_valor_{{ $inscritos->id  }}" value="{{ $inscritos->org_evento }}" />
                                        <div id="celula_f_{{ $inscritos->id }}">
                                            @if ( $inscritos->org_evento == 'S') Sim @else Não @endif
                                        </div>
                                    </td>
                                    <td align="center">
                                        <input type="hidden" id="ouvinte_valor_{{ $inscritos->id  }}" value="{{ $inscritos->ouvinte }}" />
                                        <div id="celula_g_{{ $inscritos->id }}">
                                            @if ( $inscritos->ouvinte == 'S') Sim @else Não @endif
                                        </div>
                                    </td>

                                    <td align="left">
                                        <div class="card-toolbar">
                                            <button type="button" class="btn btn-sm btn-light-primary" onClick="return abrirModalEditarParticipante('{{ $inscritos->id }}');" data-bs-toggle="modal" data-bs-target="#modal_editar_participante_evento">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                                <span class="svg-icon svg-icon-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </button>
                                        </div>
                                    </td>

                                    <td align="left">
                                        <div class="card-toolbar">
                                            <button type="button" class="btn btn-sm btn-light-danger" onClick="return excluirParticipanteEvento('{{ $inscritos->id }}');">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                                <span class="svg-icon svg-icon-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tr>
                                <td align="center">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Total de inscritos:
                                            <span class="badge badge-primary badge-pill">{{sizeof($inscrito)}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Vagas Disponíveis
                                            <span class="badge badge-primary badge-pill">{{$qtd_vagas}}</span>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                        <!--end::Table-->
                    </div>
                    @else
                    <div>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total de inscritos:
                                <span class="badge badge-primary badge-pill">{{sizeof($inscrito)}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Vagas Disponíveis
                                <span class="badge badge-primary badge-pill">{{$qtd_vagas}}</span>
                            </li>
                        </ul>
                        <br>
                    </div>
                    <!--end::Table container-->
                    @endif
                </div>
                <!--begin::Body-->

            </div>
            <!--end::Tabela-->

        </div>
    </div>
</div>


@include('layout.footer')
@include('painel.evento.js')
@include('painel.evento.editarParticipanteEvento')

<link href="{{ url ('assets/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ url ('assets/js/datatables.bundle.js') }}"></script>

<link rel="stylesheet" href="{{ url ('assets/css/bootstrap-select.css') }}" />
<script src="{{ url ('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url ('assets/js/bootstrap-select.min.js') }}"></script>