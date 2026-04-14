@include('layout.header')


<!--begin::Conteúdo-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">

            <!--begin::Tabela-->
            <div class="card mb-5 mb-xl-5">
                <!--begin::Header-->
                <div class="card mb-5 mb-xl-5">

                    <div class="card-header border-0 pt-2">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Participantes</span>

                        </h3>

                        <div class="card-toolbar">
                            <a href="{{ route ('painel.home') }}" class="btn btn-sm btn-light-primary"> Voltar</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form" action="#" method="get" onsubmit="return validarForm();">
                        @csrf

                        <div class="form-group row">

                            <div class="col-lg-3">

                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>Nome</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" id="nome" name="nome" value="@if(isset($dados['nome'])){{ $dados['nome'] }}@endif" />

                            </div>

                            <div class="col-lg-3">

                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>CPF</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" id="cpf" name="cpf" value="@if(isset($dados['cpf'])){{ $dados['cpf'] }}@endif" maxlength="14" onkeyup="mascara_cpf()" />

                            </div>

                            <div class="col-lg-3">

                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>E-mail</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" id="email" name="email" value="@if(isset($dados['email'])){{ $dados['email'] }}@endif" />

                            </div>

                            <div class="col-lg-3">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>Tipo Pessoa</span>
                                </label>
                                <select class="form-control form-control-solid" id="tipo_pessoa" name="tipo_pessoa">
                                    <option value="">Selecione</option>
                                    <option @if($tp_pesssoa=="Civil" ) selected @endif value="Civil">Civil</option>
                                    <option @if($tp_pesssoa=="Militar" ) selected @endif value="Militar">Militar</option>

                                </select>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">

                            <div class="col-lg-12" align="left">
                                <button type="submit" class="btn btn-sm btn-light-primary">Buscar</button>
                                <a href="{{route('participantes')}}"> <button type="button" class="btn btn-sm btn-secondary">Limpar</button></a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

            <!--begin::Tabela-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Body-->
                <div class="card-body py-3">
                    <br>
                    <div class="form-group row">

                        <div class="col-lg-12" align="left">
                            <div class="col-lg-12" align="left">

                                <a href="{{route('cadastroParticipanteCpf.index')}}" class="btn btn-sm btn-light-primary">
                                    <span class="svg-icon svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                                        </svg>
                                    </span>
                                    Novo Participante</a>
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
                    <br>

                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-2">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bolder text-muted bg-secondary">
                                    <th style="width:25%" class="ps-3 min-w-10px rounded-start">
                                        <font size="2">Nome</font>
                                    </th>
                                    <th style="width:15%">
                                        <font size="2">CPF</font>
                                    </th>
                                    <th style="width:15%">
                                        <font size="2">Tipo Pessoa</font>
                                    </th>
                                    <th style="width:20%">
                                        <font size="2">Email </font>
                                    </th>
                                    @if(Auth::user()->perfil_id == 2)
                                    <th style="width:20%">
                                        <font size="2">Telefone</font>
                                    </th>

                                    <th class="min-w-100px text-end rounded-end"></th>
                                    @else
                                        <th style="width:20%" class="text-left rounded-end" >
                                            <font size="2">Telefone</font>
                                        </th>
                                    @endif
                                </tr>
                                </tr>
                            </thead>

                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>


                                @foreach($pessoas as $pessoa)
                                <tr>
                                    <td>
                                        <div>
                                            <h4 class="text-dark fw-bolder text-hover-primary d-block mb-1  fs-6">{{ $pessoa->nome }}</h4>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h4 class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">{{ $pessoa->cpf }}</h4>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h4 class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"> @if($pessoa->tipo_pessoa == "Outro Militar") Público Externo Militar @elseif($pessoa->tipo_pessoa == "Outro Civil") Público Externo Civil @else {{ $pessoa->tipo_pessoa }} @endif</h4>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h4 class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">{{ $pessoa->email }}</h4>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <h4 class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6">{{$pessoa->telefone}}</h4>
                                        </div>
                                    </td>
                                    @if(Auth::user()->perfil_id == 2)
                                        <td>
                                            <div class="card-toolbar">
                                                <a href="{{ route('cadastroParticipante.edit',$pessoa->id) }}" class="btn btn-sm btn-light-primary">
                                                    Editar
                                                </a>
                                        </td>
                                    @endif

                    </div>

                    </td>
                    </tr>
                    @endforeach



                    </tbody>
                    <!--end::Table body-->
                    </table>
                    <!--end::Table-->

                    <div class="d-flex justify-content-between mb-3">
                        <div class="fs-6" colspan="6">@php echo "Total de ".sizeof($pessoas)." registro(s)." @endphp </div>
                        {{ $pessoas->links() }}
                    </div>

                </div>
                <!--end::Table container-->
            </div>
            <!--begin::Body-->
        </div>
        <!--end::Tabela-->

    </div>
</div>
</div>
<!--end::Content-->
@include('painel.js.jsHelpers')
@include('layout.footer')
@include('painel.cadastro_participante.js')



</body>
<!--end::Body-->

</html>