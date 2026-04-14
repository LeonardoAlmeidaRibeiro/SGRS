@include('../layout.header')

@php
$dados_usuario = Session::get('usuario');
$chefia = [20, 23, 67, 8, 18, 68];
@endphp

<style>
    select[readonly] {
        background: #eee;
        /*Simular campo inativo - Sugestão @GabrielRodrigues*/
        pointer-events: none;
        touch-action: none;
    }
</style>
<!--begin::Conteúdo-->
<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <!--begin::Post-->
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--
                    SERVIÇOS DTEP
                -->
            <div class="row g-5 g-xl-8">
                <!--begin::Col-->
                <div class="col-xl-12">
                    <!--begin::List Widget 1-->
                    <div class="card mb-xl-12" style="margin-bottom: 0rem!important">

                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder text-dark">Cadastrar Participante</span>
                                <span class="text-muted mt-1 fw-bold fs-7">Preencha os campos obrigátorios para cadastrar um participante</span>
                            </h3>
                        </div>

                        <div class="card-body py-3">

                            <form class="form" method="post" action="#">
                                @csrf

                                <div class="d-flex flex-column mb-7 fv-row">

                                    <div class="form-group row">

                                        <div class="col-lg-2">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">CPF</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" id="cpf" name="cpf" value="{{$cpf}}" @if($tipo_pessoa=="Militar" || $tipo_pessoa=="Civil" ) @if($cpf !=null) readonly @endif @endif maxlength="14" onkeyup="mascara_cpf()">
                                        </div>

                                        <div class="col-lg-4">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Nome</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" id="nome" name="nome" value="{{$nome}}" @if($tipo_pessoa=="Militar" || $tipo_pessoa=="Civil" ) @if($nome !=null) readonly @endif @endif>

                                        </div>

                                        <div class="col-lg-3">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Tipo Pessoa</span>
                                            </label>
                                            <select class="form-control form-control-solid" id="tipo_pessoa" name="tipo_pessoa" @if($exists==true) readonly="readonly" @endif onchange="mostrarCampos();">
                                                <option value="">Selecione</option>
                                                @if($exists == true)
                                                <option value="Militar" @if($tipo_pessoa=="Militar" ) selected @endif>Servidor Militar</option>
                                                <option value="Civil" @if($tipo_pessoa=="Civil" ) selected @endif>Servidor Civil</option>
                                                @else
                                                <option value="Outro Militar">Público Externo Militar</option>
                                                <option value="Outro Civil">Público Externo Civil</option>
                                                @endif
                                            </select>

                                        </div>
                                        <div class="col-lg-3">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Categoria Profissional</span>
                                            </label>
                                            <select class="form-control form-control-solid" id="categoria_profissional_id" name="categoria_profissional_id" onchange="mostrarCampos();">
                                                <option value="">Selecione</option>
                                                @foreach ($categoria_profissional as $categoria_profissionais )
                                                <option value="{{$categoria_profissionais->id}}">{{$categoria_profissionais->nome}}</option>
                                                @endforeach
                                            </select>

                                        </div>



                                    </div>
                                </div>

                                <div class="d-flex flex-column mb-7 fv-row">
                                    <div class="form-group row">

                                        <div class="col-lg-2">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Genêro</span>
                                            </label>
                                            <select class="form-control form-control-solid" id="genero" name="genero" @if($exists==true) @if($genero_id !=null) readonly="readonly" @endif @endif>
                                                <option value="">Selecione</option>

                                                @foreach($generos['dados'] as $genero)
                                                <option value="{{ $genero['id'] }}" @if($genero_id==$genero['id']) selected @endif>{{$genero['nome']}}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="col-lg-2">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Estado Civil</span>
                                            </label>
                                            <select class="form-control form-control-solid" id="estado_civil" name="estado_civil" @if($exists==true) @if($estado_civil_id !=null) readonly="readonly" @endif @endif>
                                                <option value="">Selecione</option>
                                                @foreach($estados_civis['dados'] as $estado_civil)
                                                <option value="{{ $estado_civil['id'] }}" @if($estado_civil_id==$estado_civil['id']) selected @endif>{{$estado_civil['nome']}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="col-lg-2">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Escolaridade</span>
                                            </label>
                                            <select class="form-control form-control-solid" id="escolaridade" name="escolaridade" @if($exists==true) @if($escolaridade_id !=null) readonly="readonly" @endif @endif>
                                                <option value="">Selecione</option>

                                                @foreach($escolaridades['dados'] as $escolaridade)
                                                <option value="{{ $escolaridade['id'] }}" @if($escolaridade_id==$escolaridade['id']) selected @endif>{{$escolaridade['nome']}}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="col-lg-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Email</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" id="email" name="email" value="{{ $email }}" @if($tipo_pessoa=="Militar" || $tipo_pessoa=="Civil" ) @if($email !=null) readonly @endif @endif>

                                        </div>

                                        <div class="col-lg-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Telefone</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" id="telefone" name="telefone" value="{{ $telefone }}" @if($tipo_pessoa=="Militar" || $tipo_pessoa=="Civil" ) @if($telefone !=null) readonly @endif @endif>
                                        </div>


                                    </div>
                                </div>

                                <hr style="color:gray">

                                <div class="d-flex flex-column mb-7 fv-row">
                                    <div class="form-group row">


                                        <div class="col-lg-2">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span>CEP</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" id="cep" name="cep" value="{{ $cep }}" @if($tipo_pessoa=="Militar" || $tipo_pessoa=="Civil" ) @if($cep !=null) readonly @endif @endif>

                                        </div>

                                        <div class="col-lg-4">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Endereço</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" id="endereco" name="endereco" value="{{ $endereco }}" @if($tipo_pessoa=="Militar" || $tipo_pessoa=="Civil" ) @if($endereco !=null) readonly @endif @endif>

                                        </div>

                                        <div class="col-lg-2">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Bairro</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" id="bairro" name="bairro" value="{{ $bairro }}" @if($tipo_pessoa=="Militar" || $tipo_pessoa=="Civil" ) @if($bairro !=null) readonly @endif @endif>

                                        </div>

                                        <div class="col-lg-2">
                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Complemento</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" id="complemento" name="complemento" value="{{ $complemento }}" @if($tipo_pessoa=="Militar" || $tipo_pessoa=="Civil" ) @if($complemento !=null) readonly @endif @endif>
                                        </div>

                                        <div class="col-lg-2">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Cidade/UF</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" id="cidade_uf" name="cidade_uf" value="{{ $cidade }}" @if($tipo_pessoa=="Militar" || $tipo_pessoa=="Civil" ) @if($cidade !=null) readonly @endif @endif>

                                        </div>






                                    </div>
                                </div>

                                <div id="militar_externo">

                                </div>

                                @if($tipo_pessoa == "Militar" || $tipo_pessoa == "")
                                <div id="militar">
                                    <hr style="color:gray">
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <div class="form-group row">
                                            <br>

                                            <div class="col-lg-3" id="forca_id">

                                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                    <span class="required">Força</span>
                                                </label>
                                                <select class="form-control form-control-solid" id="forca" name="forca" @if($exists==true) @if($forca_id !=null) readonly="readonly" @endif @endif>
                                                    <option value="">Selecione</option>

                                                    @foreach($forcas['dados'] as $forca)
                                                    <option value="{{ $forca['id'] }}" @if($forca['id']==$forca_id) selected @endif>{{$forca['nome']}}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="col-lg-3" id="qualificacao_id">

                                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                    <span class="required">Qualificação Militar</span>
                                                </label>
                                                <select class="form-control form-control-solid" id="qas_qms" name="qas_qms" @if($exists==true) @if($qualificacoes_id !=null) readonly="readonly" @endif @endif>
                                                    <option value="">Selecione</option>

                                                    @foreach($qualificacoes['dados'] as $qualificacao)
                                                    <option value="{{ $qualificacao['id'] }}" @if($qualificacao['id']==$qualificacoes_id) selected @endif>{{$qualificacao['nome']}}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            @if($exists != true)
                                            <div class="col-lg-3" id="password">
                                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                    <span class="required">Senha</span>
                                                </label>
                                                <input type="password" class="form-control form-control-solid" id="senha" name="senha">
                                            </div>

                                            <div class="col-lg-3" id="password_2">
                                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                    <span class="required">Confirmar Senha</span>
                                                </label>
                                                <input type="password" class="form-control form-control-solid" id="senha_2" name="senha_2">
                                            </div>
                                            @endif


                                            <br>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <div class="form-group row">

                                            <div class="col-lg-3" id="especialidade_id">

                                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                    <span class="required">Especialidade</span>
                                                </label>
                                                <select class="form-control form-control-solid" id="especialidade" name="especialidade" @if($exists==true) @if($especialidade_id !=null) readonly="readonly" @endif @endif>
                                                    <option value="">Selecione</option>

                                                    @foreach($especialidades['dados'] as $especialidade)
                                                    <option value="{{ $especialidade['id'] }}" @if($especialidade['id']==$especialidade_id) selected @endif>{{$especialidade['nome']}}</option>
                                                    @endforeach

                                                </select>

                                            </div>

                                            <div class="col-lg-3" id="posto_id">

                                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                    <span class="required">Posto Graduação</span>
                                                </label>
                                                <select class="form-control form-control-solid" id="posto_graduacao" name="posto_graduacao" @if($exists==true) @if($posto_graduacao_id !=null) readonly="readonly" @endif @endif>
                                                    <option value="">Selecione</option>

                                                    @foreach($postos['dados'] as $posto)
                                                    <option value="{{ $posto['id'] }}" @if($posto['id']==$posto_graduacao_id) selected @endif>{{$posto['nome']}}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <div class="form-group row">


                                            <div class="col-lg-3" id="status_id">

                                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                    <span class="required">Status Militar</span>
                                                </label>
                                                <select class="form-control form-control-solid" id="status_militar" name="status_militar" @if($exists==true) @if($status_militar_id !=null) readonly="readonly" @endif @endif>
                                                    <option value="">Selecione</option>
                                                    @foreach($status_militar['dados'] as $status)
                                                    <option value="{{ $status['id'] }}" @if($status['id']==$status_militar_id) selected @endif>{{$status['nome']}}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @endif

                                <hr style="color:gray">
                                <!--begin::Actions-->
                                <div class="text-center pt-7">
                                    <a href="{{ route ('painel.home') }}" id="cancelar" class="btn btn-danger">
                                        <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen040.svg-->
                                        <span class="svg-icon svg-icon-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black" />
                                                <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="black" />
                                                <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="black" />
                                            </svg></span>
                                        <!--end::Svg Icon-->
                                        Cancelar
                                    </a>
                                    <button type="button" id="salvarCadastro" class="btn btn-primary" onclick="return executarCriar()">
                                        <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen043.svg-->
                                        <span class="svg-icon svg-icon-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black" />
                                                <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="black" />
                                            </svg></span>
                                        <!--end::Svg Icon-->
                                        Salvar
                                    </button>
                                    <div>

                            </form>

                        </div>

                        <!--end::Body-->


                    </div>
                </div>


                <div class="col-xl-12">

                </div>

            </div>
            <br>

        </div>
    </div>
</div>
<!--end::Conteúdo-->
@include('painel.cadastro_participante.js')
@include('painel.js.jsHelpers')
@include('../layout.footer')


<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script src="{{ url('assets/js/chartjs-plugin-datalabels.js') }}"></script>


</body>
<!--end::Body-->

</html>
