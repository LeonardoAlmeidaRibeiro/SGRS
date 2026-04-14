@include('layout.header')
<script src="{{ url('assets/ckeditor/build/ckeditor.js') }}"></script>

<!--begin::Conteúdo-->
<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <!--begin::Post-->
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">

            <!--begin::Tabela-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->

                <div class="card-header border-0 pt-5">
                    <div class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Configuração do Certificado de: {{$certificados->tipo_certificado}}</span>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{route('listarCertificado.index', $certificados->evento_id)}}" class="btn btn-sm btn-light-primary">Voltar</a>
                    </div>
                </div>

                <div class="card-body py-3">
                    <!--begin::Table container-->
                    
                    <form method="POST" action="{{ route('editarCertificado.store', $certificados->id) }}">
                        @csrf
                        <div class="bg-secondary rounded" >
                            <div class="align-items-center fs-4 fw-bold p-3">Frente</div>
                        </div>
                        <div class="d-flex flex-row" >
                            <div class="form-group w-50 p-3" >
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">Texto</label>
                                <textarea data-url="{{ route('editarCertificado.upload')}}" class="ckeditor form-control" name="texto_id" id="texto_id">{{$certificados->texto}}</textarea>
                            </div>
                            <div class="form-group w-50 p-3">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">Assinatura 1</label>
                                <textarea data-url="{{ route('editarCertificado.upload')}}" class="ckeditor form-control" name="assinatura_1_id" id="assinatura_1_id">{{$certificados->assinatura_1}}</textarea>
                            </div>
                           
                        </div>
                        <div class="d-flex flex-row">
                            <div class="form-group w-50 p-3">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">Assinatura 2</label>
                                <textarea data-url="{{ route('editarCertificado.upload')}}" class="ckeditor form-control" name="assinatura_2_id" id="assinatura_2_id">{{$certificados->assinatura_2}}</textarea>
                            </div>
                            <div class="form-group w-50 p-3">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">Assinatura 3</label>
                                <textarea data-url="{{ route('editarCertificado.upload')}}" class="ckeditor form-control" name="assinatura_3_id" id="assinatura_3_id">{{$certificados->assinatura_3}}</textarea>
                            </div>
                           
                        </div>

                        <div class="d-flex flex-row">
                            <div class="form-group w-50 p-3">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">Logo Canto Superior Direito (Se Houver)</label>
                                <textarea data-url="{{ route('editarLogo.upload')}}" class="ckeditor form-control" name="logo_superior_id" id="logo_superior_id">{{$certificados->logo_superior}}</textarea>
                            </div>
                        </div>

                        <div class="bg-secondary rounded mt-6" >
                            <div class="align-items-center fs-4 fw-bold p-4">Verso</div>
                        </div>
                        <div class="d-flex flex-row" >
                            <div class="form-group w-50 p-3" >
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">Conteúdo Programático</label>
                                <textarea data-url="{{ route('editarCertificado.upload')}}" class="ckeditor form-control" name="cont_progra_id" id="cont_progra_id">{{$certificados->conteudo_programatico}}</textarea>
                            </div>
                            <div class="form-group w-50 p-3">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">Texto</label>
                                <textarea data-url="{{ route('editarCertificado.upload')}}" class="ckeditor form-control" name="texto_verso_id" id="texto_verso_id">{{$certificados->texto_verso}}</textarea>
                            </div>
                           
                        </div>
                        <div class="d-flex flex-row">
                            <div class="form-group w-50 p-3">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">Assinatura </label>
                                <textarea data-url="{{ route('editarCertificado.upload')}}" class="ckeditor form-control" name="assinatura_verso_id" id="assinatura_verso_id">{{$certificados->assinatura_verso}}</textarea>
                            </div>
                            <div class="d-flex flex-column p-3">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-0">Livro</label>
                                <input type="text" class="form-control form-control-solid mb-4" name="livro_id" id="livro_id" value="{{$certificados->livro}}">
                            
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-0">Folha</label>
                                <input type="text" class="form-control form-control-solid mb-4" name="folha_id" id="folha_id" value="{{$certificados->folha}}">
                            
                                <labelabel class="d-flex align-items-center fs-6 fw-bold form-label mb-0">Data do Livro</labelabel>
                                <input type="date" class="form-control form-control-solid mb-4" name="data_id" id="data_id" value="{{$certificados->data_livro}}">
                            </div>
                        </div>
                        <div class="d-flex flex-row">
                            <div class="form-group w-100 p-3">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">Logos de Apoio e Organização (Se Houver) </label>
                                <textarea data-url="{{ route('editarLogo.upload')}}" class="ckeditor form-control" name="logos_inferiores_id" id="logos_inferiores_id">{{$certificados->logos_inferiores}}</textarea>
                            </div>
                        </div>
                        <div class="text-center mt-6">
                            <button class="btn btn-lg btn-primary" type="submit">Salvar</button>
                            <a type="button" href="{{ route('previaCertificado.index', $certificados->tipo_certificado.'-'.$certificados->evento_id.'-'.'0')}}" target="_blank" class="btn btn-lg btn-warning">Pré-Visualizar</a>
                        </div>
                    </form>
                  
                    <!--end::Table container-->
                </div>
                <!--begin::Body-->
            </div>
            <!--end::Tabela-->

        </div>
    </div>
</div>

@include('layout.footer')

<link href="{{ url('assets/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ url('assets/js/datatables.bundle.js') }}"></script>


@include('painel.certificado.editorJs')

</body>
<!--end::Body-->


</html>