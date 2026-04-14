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

            @if(Auth::user()->perfil_id != 1)

                <div class="row g-5 g-xl-12">

                    <div class="col-xl-12">
                        <!--begin::List Widget 1-->
                        <div class="card mb-xl-12" style="margin-bottom: 0rem!important">

                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bolder text-dark">Serviços DTEP - Eventos</span>
                                    <span class="text-muted mt-1 fw-bold fs-7">Acesse os serviços abaixo</span>
                                </h3>
                            </div>

                            <div class="row g-5 g-xl-12">

                                @if(Auth::user()->perfil_id != 3)
                                    <div class="col-xl-3">

                                        <div class="card-body pt-2">

                                            <!--begin::Item-->
                                            <div class="d-flex align-items-center mb-7">
                                                <div class="symbol symbol-50px me-5">
                                                    <a href="{{route('eventos.create')}}">
                                                        <span class="symbol-label bg-light-primary">
                                                            <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen014.svg-->
                                                            <span class="svg-icon svg-icon-primary svg-icon-2hx "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="black" />
                                                                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="black" />
                                                                    <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="black" />
                                                                </svg></span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>
                                                </div>

                                                <div class="d-flex flex-column">
                                                    <a href="{{route('eventos.create')}}" class="text-dark text-hover-primary fs-6 fw-bolder">Cadastrar Evento</a>
                                                </div>

                                            </div>
                                            <!--end::Item-->



                                        </div>


                                    </div>

                                    <div class="col-xl-3">

                                        <div class="card-body pt-2">

                                            <!--begin::Item-->
                                            <div class="d-flex align-items-center mb-7">
                                                <div class="symbol symbol-50px me-5">
                                                    <a href="#">
                                                        <span class="symbol-label bg-light-primary">
                                                            <!--begin::Svg Icon | path: assets/media/icons/duotune/communication/com013.svg-->
                                                            <span class="svg-icon svg-icon-primary svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="black" />
                                                                    <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="black" />
                                                                </svg></span>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </a>
                                                </div>

                                                <div class="d-flex flex-column">
                                                    <a href="{{route('cadastroParticipanteCpf.index')}}" class="text-dark text-hover-primary fs-6 fw-bolder">Cadastrar Participante</a>
                                                </div>

                                            </div>
                                            <!--end::Item-->



                                        </div>


                                    </div> 
                                @endif
                                
                                @if(Auth::user()->perfil_id != 2)
                                    <div class="col-xl-3">
                                        <div class="card-body pt-2">

                                            <!--begin::Item-->
                                            <div class="d-flex align-items-center mb-7">
                                                <div class="symbol symbol-50px me-5">
                                                    <a href="{{route('autorizarCertificados.index')}}">
                                                        <span class="symbol-label bg-light-primary">
                                                            <!-- icone -->
                                                            <i class="las la-clipboard-check fs-3x text-primary"></i>
                                                        </span>
                                                    </a>
                                                </div>

                                                <div class="d-flex flex-column">
                                                    <a href="{{route('autorizarCertificados.index')}}" class="text-dark text-hover-primary fs-6 fw-bolder">Autorizar Certificados</a>
                                                </div>

                                            </div>
                                            <!--end::Item-->

                                        </div>
                                    </div>

                                @endif

                                @if(Auth::user()->perfil_id != 1)
                                    <div class="col-xl-3">

                                        <div class="card-body pt-2">

                                            <!--begin::Item-->
                                            <div class="d-flex align-items-center mb-7">
                                                <div class="symbol symbol-50px me-5">
                                                    <a href="{{route('relatorios.index')}}">
                                                        <span class="symbol-label bg-light-primary">
                                                            <span class="svg-icon svg-icon-2x svg-icon-primary">
                                                                <!--begin::Svg Icon | path: assets/media/icons/duotune/graphs/gra012.svg-->
                                                                <span class="svg-icon svg-icon-primary svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                        <path opacity="0.3" d="M8.4 14L15.6 8.79999L20 9.90002V6L16 4L9 11L5 12V14H8.4Z" fill="black" />
                                                                        <path d="M21 18H20V12L16 11L9 16H6V3C6 2.4 5.6 2 5 2C4.4 2 4 2.4 4 3V18H3C2.4 18 2 18.4 2 19C2 19.6 2.4 20 3 20H4V21C4 21.6 4.4 22 5 22C5.6 22 6 21.6 6 21V20H21C21.6 20 22 19.6 22 19C22 18.4 21.6 18 21 18Z" fill="black" />
                                                                    </svg></span>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                    </a>
                                                </div>

                                                <div class="d-flex flex-column">
                                                    <a href="{{route('relatorios.index')}}" class="text-dark text-hover-primary fs-6 fw-bolder">Relatórios</a>
                                                </div>

                                            </div>
                                            <!--end::Item-->



                                        </div>


                                    </div>
                                @endif

                                <div class="col-xl-3">

                                </div>


                            </div>

                        </div>
                    </div>
                    
                    <div class="row g-5 g-xl-8">
                        <div class="col-xl-3">
                            <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ url('assets/imagens/abstract-4.svg') }})">
                                <div class="card-body">
                                    <span class="svg-icon svg-icon-2x">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24">
                                                </rect>
                                                <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5"></rect>
                                                <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5">
                                                </rect>
                                                <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5">
                                                </rect>
                                                <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5">
                                                </rect>
                                            </g>
                                        </svg>
                                    </span>
                                    <div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">Eventos</div>
                                    <!--<div id="total_eventos_ativos" class="fw-bold text-gray-400 fs-5"></div>
                                    <div id="total_eventos_inativos" class="fw-bold text-gray-400 fs-5"></div>-->
                                    <div id="total_eventos" class="fw-bold text-gray-400 fs-5"></div>
                                    <br>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ url('assets/imagens/abstract-1.svg') }})">
                                <div class="card-body">
                                    <span class="svg-icon svg-icon-2x">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24">
                                                </rect>
                                                <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5"></rect>
                                                <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5">
                                                </rect>
                                                <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5">
                                                </rect>
                                                <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5">
                                                </rect>
                                            </g>
                                        </svg>
                                    </span>
                                    <div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">Participantes</div>
                                    <!--<div id="total_participante_militar" class="fw-bold text-gray-400 fs-7"></div>
                                    <div id="total_participante_civil" class="fw-bold text-gray-400 fs-7"></div>
                                    <div id="total_participante_ext_militar" class="fw-bold text-gray-400 fs-7"></div>
                                    <div id="total_participante_ext_civil" class="fw-bold text-gray-400 fs-7"></div>-->
                                    <div id="total_participantes_card" class="fw-bold text-gray-400 fs-5"></div>
                                    <br>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-3">
                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-body ">
                                <div class="fs-4 fw-bolder">Certificados Emitidos</div>
                                <span class="text-muted fw-bold fs-7">
                                    <div id="total_inscricoes_certificados"></div>
                                </span>
                                <div class="d-flex flex-wrap">
                                    <div class="d-flex flex-center me-9 mb-5">
                                        <canvas id="certificados_emitidos" width="300px" height="200px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">

                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-body ">
                                <div class="fs-4 fw-bolder">Formas de Conhecimento</div>
                                <span class="text-muted fw-bold fs-7">
                                    <div id="total_inscricoes_conhecimento"></div>
                                </span>
                                <div class="d-flex flex-wrap">
                                    <div class="d-flex flex-center me-12 mb-5">
                                        <canvas id="forma_conhecimento" width="300px" height="200px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-3">

                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-body ">
                                <div class="fs-4 fw-bolder">Tipos de Participantes</div>
                                <span class="text-muted fw-bold fs-7">
                                    <div id="total_inscricoes_participantes"></div>
                                </span>
                                <div class="d-flex flex-wrap">
                                    <div class="d-flex flex-center me-9 mb-5">
                                        <canvas id="tipo_participante" width="300px" height="200px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-3">

                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-body ">
                                <div class="fs-4 fw-bolder">Gêneros</div>
                                <span class="text-muted fw-bold fs-7">
                                    <div id="total_inscricoes_generos"></div>
                                </span>
                                <div class="d-flex flex-wrap">
                                    <div class="d-flex flex-center me-9 mb-5">
                                        <canvas id="generos" width="300px" height="200px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-3">
                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-body ">
                                <div class="fs-4 fw-bolder">Formas de Inscrição</div>
                                <span class="text-muted fw-bold fs-7">
                                    <div id="total_inscricoes"></div>
                                </span>
                                <div class="d-flex flex-wrap">
                                    <div class="d-flex flex-center me-9 mb-5">
                                        <canvas id="forma_inscricao" width="300px" height="200px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">

                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-body ">
                                <div class="fs-4 fw-bolder">Categoria de Evento</div>
                                <span class="text-muted fw-bold fs-7">
                                    <div id="total_categoria_eventos"></div>
                                </span>
                                <div class="d-flex flex-wrap">
                                    <div class="d-flex flex-center me-9 mb-5">
                                        <canvas id="categoria_evento" width="300px" height="200px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-3">

                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-body ">
                                <div class="fs-4 fw-bolder">Profissionais Participantes</div>
                                <span class="text-muted fw-bold fs-7">
                                    <div id="total_categoria_profissional"></div>
                                </span>
                                <div class="d-flex flex-wrap">
                                    <div class="d-flex flex-center me-9 mb-5">
                                        <canvas id="categoria_profissional" width="300px" height="200px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            @else

                    <div class="alert alert-dismissible bg-light-danger d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10 border border-danger border-dashed">
                      
                        <!--begin::Wrapper-->
                        <div class="text-center ">
                            <!--begin::Title-->
                            <h1 class="fw-bold mb-5"><br>O seu usuário não tem acesso as ferramentas do SGE!<br><br> Para obter acesso entre em contato com o administrador do SGE na DTEP.</h1>
                            <!--end::Title-->

                            <!--begin::Content-->
                            <div class="mb-9 text-dark" style="font-size: 18px;">
                                
                            </div>
                            <!--end::Content-->

                        </div>
                        <!--end::Wrapper-->
                    </div>


            @endif

        </div>
    </div>
</div>

<!--end::Conteúdo-->

@include('../layout.footer')

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script src="{{ url('assets/js/chartjs-plugin-datalabels.js') }}"></script>

@include('painel.js.jsHome')
</body>
<!--end::Body-->

</html>