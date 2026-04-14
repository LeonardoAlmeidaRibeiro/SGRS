@include('layout.header')


<!--begin::Conteúdo-->
<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <!--begin::Post-->
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">


            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">{{$eventos->nome_evento}}</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{route('eventos.index')}}" class="btn btn-sm btn-light-primary">
                            Voltar
                        </a>
                    </div>
                </div>

                <div class="card-body py-3">
                    <div class="table-responsive">
                        <table id="tabela" class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                            <thead>
                                <tr class="fw-bolder text-muted bg-secondary">
                                    <th class="ps-4 min-w-325px rounded-start">Ações</th>
                                    <th class="min-w-200px text-end rounded-end"></th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <td>
                                        <a href="{{route('eventos.relacaoInscritosDadosPessoais',$eventos->id)}}" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">
                                            <div>Relação de Inscritos com Dados Pessoais</div>
                                        </a>
                                    </td>
                                    <td class="text-end">
                                        <div class="card-toolbar">
                                            <a href="{{route('eventos.relacaoInscritosDadosPessoais',$eventos->id)}}" class="btn btn-sm btn-light-primary">
                                                <span class="svg-icon svg-icon-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                                    </svg>
                                                </span>
                                                Visualizar
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="{{route('eventos.relacaoInscritosAssinatura',$eventos->id)}}" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">
                                            <div>Relação de Presença (Assinatura)</div>
                                        </a>
                                    </td>
                                    <td class="text-end">
                                        <div class="card-toolbar">
                                            <a href="{{route('eventos.relacaoInscritosAssinatura',$eventos->id)}}" class="btn btn-sm btn-light-primary">
                                                <span class="svg-icon svg-icon-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                                    </svg>
                                                </span>
                                                Visualizar
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('layout.footer')

<link href="{{ url('assets/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ url('assets/js/datatables.bundle.js') }}"></script>


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
            "<'col-sm-12 justify-content-md-end'p>" +
            ">"
    });
</script>


</body>

</html>