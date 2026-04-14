@include('layout.header')
<!--begin::Conteúdo-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">

            <div class="card mb-5 mb-xl-5">

                <div class="card-header">
                    <div class="card-title flex-column col-11">
                        <span class="card-label fw-bolder fs-3 mb-1"> {{$evento->first()->nome_evento}} - Programação para o dia {{ date('d/m/Y', strtotime($eventoProgr->dia))}}</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Utilize os campos para adicionar um novo conteúdo na programação </span>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{route('eventos.createProgramacao',$evento->first()->eventos_id)}}" class="btn btn-sm btn-light-primary"> Voltar</a>
                    </div>
                </div>


                <div class="card-body">

                    <form class="form" method="post" action="{{route('eventos.storeConteudo')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <input type="hidden" id="evento_prog_dia_id" name="evento_prog_dia_id" value="{{$eventoProgr->id}}">
                            <div class="col-lg-1">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>Hora</span>
                                </label>
                                <input type="time" class="form-control" id="hora" name="hora" required>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>Conteúdo</span>
                                </label>
                                <textarea class="form-control" id="conteudo" name="conteudo" rows="5" required></textarea>
                            </div>
                        </div>
                        <br>
                        <div>
                            <button id="criar"class="btn btn-sm btn-light-primary" type="button" onclick="executarCriaHora()">Adicionar</button>
                        </div>
                    </form>

                </div>
            </div>

            <!--begin::Tabela-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        @if (count($horaPro) <= 0) <div align="center">
                            <br>
                            <p class="fw-bolder"> Nenhuma programação cadastrada </p>
                    </div>
                    @else
                    <table id="tabela" style="font-size: small;
                           font-weight: 500;" class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 ">
                        <thead>
                            <tr class="fw-bolder text-muted bg-secondary">
                                <th class="min-w-55px rounded-start text-center">Hora</th>
                                <th class="min-w-125px text-center">Conteúdo</th>
                                <th class="min-width-125px rounded-end" style="padding-right: 5%; text-align: right;">Ações</th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($horaPro as $horaProg )
                            <tr id="tr_{{ $horaProg->id }}">

                                <td align="center">

                                    <a href="#" onClick="return abrirModalEditarHora({{ $horaProg->id }});" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6" data-bs-toggle="modal" data-bs-target="#modal_editarHora">
                                        <div id="celula_a_{{ $horaProg->id }}">{{ $horaProg->hora}}</div>
                                    </a>
                                </td>

                                <td align="center">

                                    <a href="#" onClick="return abrirModalEditarHora({{ $horaProg->id }});" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6" data-bs-toggle="modal" data-bs-target="#modal_editarHora">
                                        <div id="celula_b_{{ $horaProg->id }}">{{ $horaProg->conteudo}}</div>
                                    </a>
                                </td>
                                <td align="right">
                                    <a href="#" class="btn btn-sm btn-light-primary" onClick="return abrirModalEditarHora('{{ $horaProg->id }}');" data-bs-toggle="modal" data-bs-target="#modal_editarHora">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                                <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->Editar
                                    </a>
                                    <button type="button" class="btn btn-sm btn-light-danger" onClick="return excluirHora('{{ $horaProg->id }}');">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        Excluir
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" align="center">
                                    <div class="d-flex justify-content-between mb-3">
                                        {{-- <div class="fs-6" colspan="5">@php echo "Total de ".sizeof($evento)." registro(s)." @endphp </div>--}}
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
@include('painel.evento.editarHora')


<link href="{{ url('assets/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ url('assets/js/datatables.bundle.js') }}"></script>

</body>
<!--end::Body-->

</html>