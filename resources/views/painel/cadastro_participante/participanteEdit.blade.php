@include('../layout.header')

@php
$dados_usuario = Session::get('usuario');
$chefia = [20, 23, 67, 8, 18, 68];
@endphp
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
                                <span class="card-label fw-bolder text-dark">Editar Participante</span>
                                <span class="text-muted mt-1 fw-bold fs-7"></span>
                            </h3>
                        </div>

                        <div class="card-body py-3">

                            <form class="form" method="post" action="#">
                                @csrf

                                <div class="d-flex flex-column mb-7 fv-row">

                                    <div class="form-group row">

                                        <div class="col-lg-2">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Tipo Pessoa</span>
                                            </label>
                                            <select class="form-control form-control-solid" id="tipo_pessoa_edit" name="tipo_pessoa_edit" onchange="mostrarCamposEdit();">
                                                <option value="">Selecione</option>
                                                <option value="Militar" @if($participantes->first()->tipo_pessoa == "Militar") selected @endif>Servidor Militar</option>
                                                <option value="Civil" @if($participantes->first()->tipo_pessoa == "Civil") selected @endif>Servidor Civil</option>
                                                <option value="Outro Civil" @if($participantes->first()->tipo_pessoa == "Outro Civil") selected @endif>Público Externo Civil</option>
                                                <option value="Outro Militar" @if($participantes->first()->tipo_pessoa == "Outro Militar") selected @endif>Público Externo Militar</option>

                                            </select>

                                        </div>

                                        <div class="col-lg-2">

                                       
                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Categoria Profissinal</span>
                                            </label>
                                            <select class="form-control form-control-solid" id="categoria_profissional_id" name="categoria_profissional_id" onchange="mostrarCamposEdit();">
                                                @foreach ($categoria_profissional as $categoria_profissionais )
                                                <option @if($participantes[0]->categoria_profissional_id == $categoria_profissionais->id ) selected @endif value="{{$categoria_profissionais->id}}" > {{$categoria_profissionais->nome}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg-2">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">CPF</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" value="{{ $participantes->first()->cpf }}" id="cpf_edit" name="cpf_edit" maxlength="14" onkeyup="mascara_cpf()" onchange="dados()">
                                        </div>

                                        <div class="col-lg-6">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Nome</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" value="{{ $participantes->first()->nome }}" id="nome_edit" name="nome_edit">

                                        </div>


                                    </div>
                                </div>

                                <div class="d-flex flex-column mb-7 fv-row">
                                    <div class="form-group row">

                                        <div class="col-lg-2">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Genêro</span>
                                            </label>
                                            <select class="form-control form-control-solid" id="genero_edit" name="genero_edit">
                                                <option value="">Selecione</option>

                                                @foreach($generos['dados'] as $genero)
                                                <option value="{{ $genero['id'] }}" @if($participantes->first()->genero == $genero['id']) selected @endif>{{$genero['nome']}}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="col-lg-2">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Estado Civil</span>
                                            </label>
                                            <select class="form-control form-control-solid" id="estado_civil_edit" name="estado_civil_edit">
                                                <option value="">Selecione</option>
                                                @foreach($estados_civis['dados'] as $estado_civil)
                                                <option value="{{ $estado_civil['id'] }}" @if($participantes->first()->estado_civil == $estado_civil['id']) selected @endif>{{$estado_civil['nome']}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="col-lg-2">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Escolaridade</span>
                                            </label>
                                            <select class="form-control form-control-solid" id="escolaridade_edit" name="escolaridade_edit">
                                                <option value="">Selecione</option>

                                                @foreach($escolaridades['dados'] as $escolaridade)
                                                <option value="{{ $escolaridade['id'] }}" @if($participantes->first()->escolaridade == $escolaridade['id']) selected @endif>{{$escolaridade['nome']}}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="col-lg-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Email</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" value="{{ $participantes->first()->email }}" id="email_edit" name="email_edit">

                                        </div>

                                        <div class="col-lg-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Telefone</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" value="{{ $participantes->first()->telefone }}" id="telefone_edit" name="telefone_edit">
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
                                            <input type="text" class="form-control form-control-solid" value="{{ $participantes->first()->cep }}" id="cep_edit" name="cep_edit">

                                        </div>

                                        <div class="col-lg-4">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Endereço</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" value="{{ $participantes->first()->endereco }}" id="endereco_edit" name="endereco_edit">

                                        </div>

                                        <div class="col-lg-2">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Bairro</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" value="{{ $participantes->first()->bairro }}" id="bairro_edit" name="bairro_edit">

                                        </div>

                                        <div class="col-lg-2">
                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Complemento</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" value="{{ $participantes->first()->complemento }}" id="complemento_edit" name="complemento_edit">
                                        </div>

                                        <div class="col-lg-2">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Cidade/UF</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" value="{{ $participantes->first()->cidade_uf }}" id="cidade_uf_edit" name="cidade_uf_edit">

                                        </div>


                                    </div>
                                </div>

                                @if($participantes->first()->tipo_pessoa == "Militar" || $participantes->first()->tipo_pessoa == "Outro Militar")
                                <div id="militar">
                                    <hr style="color:gray">
                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <div class="form-group row">
                                            <br>

                                            <div class="col-lg-3" id="forca_id_edit">

                                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                    <span class="required">Força</span>
                                                </label>
                                                <select class="form-control form-control-solid" id="forca_edit" name="forca_edit">
                                                    <option value="">Selecione</option>

                                                    @foreach($forcas['dados'] as $forca)
                                                    <option value="{{ $forca['id'] }}" @if($participantes->first()->forca == $forca['id']) selected @endif>{{$forca['nome']}}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="col-lg-3" id="qualificacao_id_edit">

                                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                    <span class="required">Qualificação Militar</span>
                                                </label>
                                                <select class="form-control form-control-solid" id="qas_qms_edit" name="qas_qms_edit">
                                                    <option value="">Selecione</option>

                                                    @foreach($qualificacoes['dados'] as $qualificacao)
                                                    <option value="{{ $qualificacao['id'] }}" @if($participantes->first()->qas_qms == $qualificacao['id']) selected @endif>{{$qualificacao['nome']}}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="col-lg-3" id="especialidade_id_edit">
                                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                    <span class="required">Especialidade</span>
                                                </label>
                                                <select class="form-control form-control-solid" id="especialidade_edit" name="especialidade_edit">
                                                    <option value="">Selecione</option>
                                                    @foreach($especialidades['dados'] as $especialidade)
                                                    <option value="{{ $especialidade['id'] }}" @if($participantes->first()->especialidade == $especialidade['id']) selected @endif>{{$especialidade['nome']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-lg-3" id="posto_id_edit">
                                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                    <span class="required">Posto Graduação</span>
                                                </label>
                                                <select class="form-control form-control-solid" id="posto_graduacao_edit" name="posto_graduacao_edit">
                                                    <option value="">Selecione</option>
                                                    @foreach($postos['dados'] as $posto)
                                                    <option value="{{ $posto['id'] }}" @if($participantes->first()->posto_graduacao == $posto['id']) selected @endif>{{$posto['nome']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <br>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column mb-7 fv-row">
                                        <div class="form-group row">


                                            <div class="col-lg-3" id="status_id_edit">

                                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                    <span class="required">Status Militar</span>
                                                </label>
                                                <select class="form-control form-control-solid" id="status_militar_edit" name="status_militar_edit">
                                                    <option value="">Selecione</option>
                                                    @foreach($status_militar['dados'] as $status)
                                                    <option value="{{ $status['id'] }}" @if($participantes->first()->status_militar == $status['id']) selected @endif>{{$status['nome']}}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @endif

                                <hr style="color:gray">

                                <div class="d-flex flex-column mb-7 fv-row">
                                    <div class="form-group row">

                                        <div class="col-lg-3" id="password">
                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Senha</span>
                                            </label>
                                            <input type="password" class="form-control form-control-solid" id="senha_edit" name="senha_edit" autocomplete="new-password">
                                        </div>

                                        <div class="col-lg-3" id="password_2">
                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Confirmar Senha</span>
                                            </label>
                                            <input type="password" class="form-control form-control-solid" id="senha_2_edit" name="senha_2_edit" autocomplete="new-password">
                                        </div>
                                    </div>
                                </div>



                                <hr style="color:gray">
                                <!--begin::Actions-->
                                <div class="text-center pt-7">
                                    <a href="{{ route ('participantes') }}" id="cancelar" class="btn btn-danger">
                                        <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen040.svg-->
                                        <span class="svg-icon svg-icon-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black" />
                                                <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="black" />
                                                <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="black" />
                                            </svg></span>
                                        <!--end::Svg Icon-->
                                        Cancelar
                                    </a>
                                    <button type="button" id="editarCadastro" class="btn btn-primary" onclick="return executarEditar('{{ $participantes->first()->id }}')">
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