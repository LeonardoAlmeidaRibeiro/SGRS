@include('../layout.header')
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
<script src="{{ url('assets/ckeditor/build/ckeditor.js') }}"></script>

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
                                <span class="card-label fw-bolder text-dark">Atualizar Evento nº {{$evento->id}}</span>
                                <span class="text-muted mt-1 fw-bold fs-7">Preencha os campos obrigátorios para atualizar o evento</span>
                            </h3>

                            <div class="card-toolbar">
                                <a href="{{route('eventos.index')}}" class="btn btn-sm btn-light-primary">Voltar</a>
                            </div>
                        </div>

                        <div class="card-body py-3">


                            <form method="post" action="#" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="d-flex flex-column mb-7 fv-row">
                                    <input type="hidden" id="atualizar_id_evento" name="atualizar_id_evento">
                                    <div class="form-group row">
                                        <div class="col-lg-6">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Nome do Evento</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" value="{{$evento->nome_evento}}" id="nome_evento" name="nome_evento" placeholder="Nome do Evento">

                                        </div>

                                        <div class="col-lg-3">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">E-Mail</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" value="{{$evento->email}}" id="email" name="email" placeholder="E-mail do Evento">
                                        </div>

                                        <div class="col-lg-3">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span>Data do Evento</span>
                                            </label>
                                            <input type="date" class="form-control form-control-solid" value="{{$evento->data_evento}}" id="data_evento" name="data_evento">

                                        </div>

                                    </div>
                                </div>

                                <div class="d-flex flex-column mb-7 fv-row">
                                    <div class="form-group row">

                                        <div class="col-lg-3">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Unidade do Evento</span>
                                            </label>

                                            <select class="form-control form-control-solid selectpicker" id="unidade_evento_id" name="unidade_evento_id" data-live-search="true">

                                                <option value=""> Selecione </option> 
                                                @foreach ($unidade_evento as $unidade_eventos )
                                                <option @if($evento->unidadeEvento()->first()->nome == $unidade_eventos->nome ) selected @endif value="{{$unidade_eventos->id}}" > {{$unidade_eventos->nome}}</option>

                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="col-lg-3">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Status do Evento</span>
                                            </label>

                                            <select class="form-control form-control-solid selectpicker" id="status_evento" name="status_evento">
                                                <option value="">Selecione</option>
                                                <option @if ($evento->status_evento == 'S')
                                                    selected
                                                    @endif value="S">Ativo</option>
                                                <option @if ($evento->status_evento == 'N')
                                                    selected
                                                    @endif value="N">Inativo</option>
                                            </select>

                                        </div>

                                        <div class="col-lg-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Categoria do Evento</span>
                                            </label>
                                            <select class="form-control form-control-solid selectpicker" id="categoria_evento_id" name="categoria_evento_id">
                                                <option value=""> Selecione </option>
                                                @foreach ($categoria_evento as $categoria_eventos )
                                                <option @if($evento->categoriaEvento()->first()->nome == $categoria_eventos->nome ) selected @endif value="{{$categoria_eventos->id}}" > {{$categoria_eventos->nome}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg-3">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Público Alvo</span>
                                            </label>
                                            <select class="form-control form-control-solid selectpicker" id="publico_alvo[]" name="publico_alvo[]" multiple datda-live-search="true">
                                                <option value="{{ $evento->publico_alvo }}">{{ $evento->publico_alvo }}</option>
                                                <option value="">Selecione</option>
                                                @foreach($publico_alvo as $publico_alvos)
                                                <option value="{{ $publico_alvos->nome }}" @if(in_array($publico_alvos->nome, explode(',', $evento->publico_alvo)))
                                                    selected
                                                    @endif
                                                    >{{ $publico_alvos->nome }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-column mb-7 fv-row">
                                    <div class="form-group row">
                                        <div class="col-md-1" style="width: 12.499999995%">
                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Carga Horária</span>
                                            </label>
                                            <input type="number" class="form-control form-control-solid" value="{{$evento->carga_horaria}}" id="carga_horaria" name="carga_horaria" placeholder="Carga Horária">

                                        </div>

                                        <div class="col-md-1" style="width: 12.499999995%">
                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Vagas do Evento</span>
                                            </label>
                                            <input type="number" class="form-control form-control-solid" value="{{$evento->vaga_evento}}" id="vaga_evento" name="vaga_evento" placeholder="Quantidade de Vagas">
                                        </div>

                                        <div class="col-lg-3">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required"> Selecionar Imagem do Evento</span>
                                            </label>
                                            <input type="file" class="form-control form-control-solid" id="imagem" name="imagem">
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span>Arquivo de Programação (PDF)</span>
                                            </label>
                                            <input type="file" class="form-control form-control-solid" id="arq_programacao" name="arq_programacao">
                                        </div>

                                        <div class="col-lg-3">
                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span>Vídeo do Evento</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" value="{{$evento->video}}" id="video" name="video" placeholder="Link do vídeo">
                                        </div>

                                    </div>
                                </div>

                                <div class="d-flex flex-column mb-7 fv-row">
                                    <div class="form-group row">

                                        <div class="col-lg-12">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Evento</span>
                                            </label>
                                            <textarea class="ck-editor form-control form-control-solid" name="evento" id="evento" placeholder="Descrição do Evento">{{$evento->descricao}} </textarea>

                                        </div>
                                        <br>
                                    </div>
                                </div>

                                <div class="d-flex flex-column mb-7 fv-row">
                                    <div class="form-group row">

                                        <div class="col-lg-12">
                                            <div style="display: grid; place-items: center;">
                                                <img src="{{ url('storage/'.$evento->imagem) }}" width="200">
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>

                                <!--begin::Actions-->
                                <div class="text-center pt-2">
                                    <a href="{{ route ('eventos.index') }}" class="btn btn-danger">
                                        <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen040.svg-->
                                        <span class="svg-icon svg-icon-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black" />
                                                <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="black" />
                                                <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="black" />
                                            </svg></span>
                                        <!--end::Svg Icon-->
                                        Cancelar
                                    </a>
                                    <a href="#" type="button" id="criar" class="btn btn-primary" onclick="atualizarEvento('{{$evento->id}}')">
                                        <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen043.svg-->
                                        <span class="svg-icon svg-icon-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black" />
                                                <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="black" />
                                            </svg></span>
                                        <!--end::Svg Icon-->
                                        Atualizar</a>
                                </div>
                                <!--end::Actions-->

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
@include('painel.evento.js')
@include('../layout.footer')


<link href="{{ url ('assets/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ url ('assets/js/datatables.bundle.js') }}"></script>

<link rel="stylesheet" href="{{ url ('assets/css/bootstrap-select.css') }}" />
<script src="{{ url ('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url ('assets/js/bootstrap-select.min.js') }}"></script>




</body>
<!--end::Body-->

</html>