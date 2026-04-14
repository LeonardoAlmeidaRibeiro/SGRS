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
                        <span class="card-label fw-bolder fs-3 mb-1">Mensagens Fala Residente</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Utilize os campos abaixo para filtrar as mensagens</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{ route ('painel.home') }}" class="btn btn-sm btn-light-primary"> Voltar</a>
                    </div>
                </div>

                <div class="card-body">
                    <form class="form" action="{{route('painel.falaResidente.index')}}" method="get">
                        @csrf
                        <div class="form-group row">

                            <div class="col-lg-3">

                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>Nome</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" id="nome" name="nome" value="@if(isset($dados['nome'])) {{ $dados['nome'] }} @endif" />
                            </div>

                            <div class="col-lg-3">

                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>E-mail</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" id="email" name="email" value="@if(isset($dados['email'])) {{ $dados['email'] }} @endif" />
                            </div>
                            <div class="col-lg-3">

                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>Documento</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" id="documento" name="documento" value="@if(isset($dados['documento'])) {{ $dados['documento'] }} @endif" />
                            </div>
                            <div class="col-lg-3">

                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span>Clínica</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" id="clinica" name="clinica" value="@if(isset($dados['clinica'])) {{ $dados['clinica'] }} @endif" />
                            </div>
                            </div><br>
                            <div class="form-group row">
                                <div class="col-lg-3">

                                    <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span>Mensagem</span>
                                    </label>
                                    <input type="text" class="form-control form-control-solid" id="mensagem" name="mensagem" value="@if(isset($dados['mensagem'])) {{ $dados['mensagem'] }} @endif" />
                                </div>
                                
                                <div class="col-lg-3">
                                    <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span>Tipo de Formulário</span>
                                    </label>
                                    <select class="form-control form-control-solid" class="form-control form-control-solid" id="tipo_formulario" name="tipo_formulario">
                                        <option selected disabled>Selecione</option>
                                        <option value="Identificado" @if(isset($dados['tipo_formulario']))@if($dados['tipo_formulario'] == "Identificado") selected @endif @endif>Identificado</option>
                                        <option value="Anonimo" @if(isset($dados['tipo_formulario']))@if($dados['tipo_formulario'] == "Anonimo") selected @endif @endif>Anônimo</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                        <span>Lido?</span>
                                    </label>
                                    <select class="form-control form-control-solid" class="form-control form-control-solid" id="lido" name="lido">
                                        <option selected disabled>Selecione</option>
                                        <option value="Sim" @if(isset($dados['lido']))@if($dados['lido'] == "Sim") selected @endif @endif>Sim</option>
                                        <option value="Não" @if(isset($dados['lido']))@if($dados['lido'] == "Não") selected @endif @endif>Não</option>
                                    </select>
                                </div>
                            </div>
                       
                        <br>
                        <div>
                            <button type="submit" class="btn btn-sm btn-light-primary">Buscar</button>
                            <a href="{{route('painel.falaResidente.index')}}"> <button type="button" class="btn btn-sm btn-secondary">Limpar</button></a>
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
                                    <th class="min-w-125px text-center">E-mail</th>
                                    <th class="min-w-125px text-center">Documento</th>
                                    <th class="min-w-125px text-center">Clínica</th>
                                    <th class="min-w-125px text-center">Recebido em</th>
                                    <th class="min-w-125px text-center">Respondido em</th>
                                    <th class="min-w-100px text-center"></th>
                                    <th class="min-w-100px text-end rounded-end"></th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($fala_residentes as $fala_residente )
                                <tr id="tr_{{ $fala_residente->id }}">
                               
                                    <input type="hidden" id="resposta_tr_{{$fala_residente->id}}" name="reposta_tr_{{$fala_residente->id}}" value="{{$fala_residente->resposta}}">
                                
                                    <input type="hidden" id="mensagem_tr{{ $fala_residente->id }}" value="@if(isset($fala_residente->mensagem)){{ $fala_residente->mensagem }}@endif" />
                                    <td align="center">
                                        {{$fala_residente->id}}
                                    </td>
                                    <td align="center">
                                       <div id="celula_a_{{$fala_residente->id}}"> @if($fala_residente->tipo_formulario == "Anonimo") @if($fala_residente->lido != null) Anônimo  @else <strong style="color:blue">Anônimo</strong> @endif @else @if($fala_residente->lido != null) {{$fala_residente->nome}} @else <strong style="color:blue">{{$fala_residente->nome}}</strong> @endif @endif</div>
                                    </td>
                                    <td align="center">
                                        @if($fala_residente->tipo_formulario == "Anonimo") @if($fala_residente->lido != null) Anônimo  @else <strong style="color:blue">Anônimo</strong> @endif @else @if($fala_residente->lido != null) {{$fala_residente->email}} @else <strong style="color:blue">{{$fala_residente->email}}</strong> @endif @endif   
                                    </td>
                                    <td align="center">
                                        @if($fala_residente->tipo_formulario == "Anonimo") @if($fala_residente->lido != null) Anônimo  @else <strong style="color:blue">Anônimo</strong> @endif @else @if($fala_residente->lido != null) {{$fala_residente->documento}} @else <strong style="color:blue">{{$fala_residente->documento}}</strong> @endif @endif   
                                    </td>
                                    <td align="center">
                                        @if($fala_residente->tipo_formulario == "Anonimo" ) @if($fala_residente->lido != null) Anônimo  @else <strong style="color:blue">Anônimo</strong> @endif @else @if($fala_residente->lido != null) {{$fala_residente->clinica}} @else <strong style="color:blue">{{$fala_residente->clinica}}</strong> @endif @endif   
                                    </td>
                                    <td align="center">
                                        @if($fala_residente->lido != null) {{date('d/m/Y', strtotime($fala_residente->created_at))}}&nbsp;{{ date('H:i', strtotime($fala_residente->created_at))}} @else <strong style="color:blue"> {{date('d/m/Y', strtotime($fala_residente->created_at))}}&nbsp;{{ date('H:i', strtotime($fala_residente->created_at))}} </strong> @endif
                                    </td>
                                    <td align="center">
                                    <div id="celula_b_{{$fala_residente->id}}"> 
                                    
                                                @if($fala_residente->lido != null) @if(isset($fala_residente->respondido_em)) {{date('d/m/Y', strtotime($fala_residente->respondido_em))}}&nbsp;{{ date('H:i', strtotime($fala_residente->respondido_em))}} @endif @else @if(isset($fala_residente->respondido_em)) <strong style="color:blue">{{date('d/m/Y', strtotime($fala_residente->respondido_em))}}&nbsp;{{ date('H:i', strtotime($fala_residente->respondido_em))}}</strong> @endif @endif
                                        
                                    </div>
                                        
                                    </td>
                                    <td align="center">
                                        <a href="#" class="btn btn-sm btn-success" @if($fala_residente->tipo_formulario == "Anonimo") onclick="return naoPodeResponder();"  @else  onclick="return abrirModalResposta('{{$fala_residente->id}}')" data-bs-toggle="modal" data-bs-target="#modal_resposta" @endif >
                                            Responder
                                        </a>
                                        <input type="hidden" id="fala_residente_{{ $fala_residente->id }}" value="{{ $fala_residente->id }}">
                                    </td>
                                    <td align="center">
                                        <a href="#"  class="btn btn-sm btn-primary" onClick="return abrirModalEditar('{{ $fala_residente->id }}');" data-bs-toggle="modal" data-bs-target="#modal_editar">
                                         Visualizar 
                                        </a>
                                    </td>
                                    

                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7" align="center">
                                        <div class="d-flex justify-content-between mb-3">
                                            <div class="fs-6" colspan="5">@php echo "Total de ".sizeof($fala_residentes)." registro(s)." @endphp </div>
                                            {{ $fala_residentes->links() }}
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

@include('site.fala_residente.verMensagem')
@include('site.fala_residente.modalResposta')
@include('layout.footer')
@include('site.fala_residente.js')


<link href="{{ url('assets/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ url('assets/js/datatables.bundle.js') }}"></script>

</body> <!--end::Body-- >
</html>