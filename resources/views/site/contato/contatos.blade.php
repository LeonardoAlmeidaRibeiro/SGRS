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
                        <span class="card-label fw-bolder fs-3 mb-1">Consultar Mensagens</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Utilize os campos abaixo para filtrar as mensagens</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{ route ('painel.home') }}" class="btn btn-sm btn-light-primary"> Voltar</a>
                    </div>
                </div>

                <div class="card-body">
                    <form class="form" action="{{route('contato.listar')}}" method="post">
                        @csrf
                        <div class="form-group row">

                            <div class="col-lg-3">

                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>Nome</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" id="nome" name="nome" value="{{$nome }} " />
                            </div>

                            <div class="col-lg-3">

                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>E-mail</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" id="email" name="email" value="{{$email }} " />
                            </div>
                        </div>
                        <br>
                        <div>
                            <button type="submit" class="btn btn-sm btn-light-primary">Buscar</button>
                            <a href="{{route('contato.listar')}}"> <button type="button" class="btn btn-sm btn-secondary">Limpar</button></a>
                        </div>
                    </form>


                </div>
            </div>

            <!--begin::Tabela-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <br>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table id="tabela" style="font-size: small;
                           font-weight: 500;" class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 ">
                            <thead>
                                <tr class="fw-bolder text-muted bg-secondary">
                                    <th class="min-w-55px rounded-start text-center">Nº</th>
                                    <th class="min-w-125px text-center">Nome</th>
                                    <th class="min-w-125px text-center">Telefone</th>
                                    <th class="min-w-125px text-center">E-mail</th>
                                    <th class="min-w-125px text-center">Data</th>
                                    <th class="min-w-125px text-center">Hora</th>
                                    <th class="min-w-100px text-end rounded-end"></th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($contatos as $contato )
                                <tr id="tr_{{ $contato->id }}">
                                    <td align="center">
                                        <input type="hidden" id="mensagem_tr{{ $contato->id }}" value="@if(isset($contato->mensagem)){{ $contato->mensagem }}@endif" />
                                        {{$contato->id}}
                                    </td>
                                    <td align="center">
                                        {{$contato->nome}}
                                    </td>
                                    <td align="center">
                                        {{$contato->telefone}}
                                    </td>
                                    <td align="center">
                                        {{$contato->email}}
                                    </td>
                                    <td align="center">
                                        {{date('d/m/Y', strtotime($contato->created_at))}}
                                    </td>
                                    <td align="center">
                                        {{ date('H:i', strtotime($contato->created_at))}}
                                    </td>
                                    <td align="center">
                                        <a href="#" class="btn btn-sm btn-light-primary" onClick="return abrirModalEditar('{{ $contato->id }}');" data-bs-toggle="modal" data-bs-target="#modal_editar">
                                            Visualizar
                                        </a>
                                        <imput hidden name="mensagem">{{ $contato->mensagem}}
                                       ; 
                                    </imput>
                                    </td>

                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7" align="center">
                                        <div class="d-flex justify-content-between mb-3">
                                            <div class="fs-6" colspan="5">@php echo "Total de ".sizeof($contatos)." registro(s)." @endphp </div>
                                            {{ $contatos->links() }}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>





                    </div>
                    <!--end::Table container-->
                </div>
                <!--begin::Body-->

            </div>
            <!--end::Tabela-->

        </div>
    </div>
</div>

@include('site.contato.verMensagem')
@include('layout.footer')
@include('site.contato.js')


<link href="{{ url('assets/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ url('assets/js/datatables.bundle.js') }}"></script>

</body> <!--end::Body-- >
</html>