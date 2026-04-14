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
                        <span class="card-label fw-bolder fs-3 mb-1" style="width:97%">{{$evento->nome_evento}}</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Utilize os campos para adicionar arquivos ao evento </span>
                    </div>
                    <div class="card-toolbar">
                        <a class="btn btn-sm btn-light-primary" href="{{route('eventos.index')}}">Voltar</a>
                    </div>
                </div>


                <div class="card-body">

                    <form class="form" method="post" action="#" enctype="multipart/form-data">

                        @csrf
                        <div class="form-group row">
                            <input type="hidden" id="evento_id" name="evento_id" value="{{$evento->id}}">
                            <div class="col-lg-3">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>Nome do Documento</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" id="nome_documento" name="nome_documento" required />
                            </div>

                            <div class="col-lg-5">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>Arquivo (doc, docx, gif, jpeg, jpg, pdf, png, pptx, txt, xls e xlsx)</span>
                                </label>
                                <input type="file" class="form-control form-control-solid" id="arquivo_documento" name="arquivo_documento" required />
                            </div>
                        </div>

                        <br>

                        <div>
                            <button id="criar" class="btn btn-sm btn-light-primary" type="button" onclick="executarSalvarDocumento()">Adicionar</button>
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
                        @if (count($documento) <= 0) <div align="center">
                            <br>
                            <p class="fw-bolder"> Nenhum arquivo adicionado. </p>
                    </div>
                    @else
                    <table id="tabela" style="font-size: small;
                            font-weight: 500;" class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 ">
                        <thead>
                            <tr class="fw-bolder text-muted bg-secondary">
                                <th style="width:70%" class="ps-3 min-w-10px rounded-start">Nome do Arquivo</th>
                                <th style="width:10%" class="ps-3 min-w-10px">Data de Inclusão</th>
                                <th style="width:10%" class="ps-3 min-w-10px"></th>
                                <th style="width:10%" class="min-w-100px rounded-end"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ( $documento as $documentos)
                            <tr id="tr_">
                                <td align="left">
                                    &nbsp; {{$documentos->nome_documento}}
                                </td>
                                <td align="left">
                                    {{date('d/m/Y', strtotime($documentos->created_at))}}
                                </td>
                                <td align="left">
                                    <a class="btn btn-sm btn-light-primary" href="{{ url('storage/'.$documentos->arquivo_documento) }}" target="_blank"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                        </svg> <span>&nbsp; Download </span></a>
                                </td>
                                <td align="left">
                                    <button type="button" class="btn btn-sm btn-light-danger" onClick="return excluirDocumentoEvento('{{ $documentos->id }}');">
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
                                        <div class="fs-6" colspan="5">@php echo "Total de ".sizeof($documento)." registro(s)." @endphp </div>
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
@include('painel.evento.editarDia')


<link href="{{ url('assets/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ url('assets/js/datatables.bundle.js') }}"></script>

</body>
<!--end::Body-->

</html>