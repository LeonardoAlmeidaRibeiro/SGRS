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
                                <span class="card-label fw-bolder text-dark">Cadastrar Participante</span>
                                <span class="text-muted mt-1 fw-bold fs-7"></span>
                            </h3>
                            <div class="card-toolbar">
                                <a href="{{ route ('painel.home') }}" class="btn btn-sm btn-light-primary"> Voltar</a>
                            </div>
                        </div>

                        <div class="card-body py-3">

                            <form class="form" method="get" action="{{route('apidados.index')}}" onsubmit="return verificarCpf();">
                                @csrf

                                <div class="d-flex flex-column mb-7 fv-row">

                                    <div class="form-group row">

                                        <div class="col-lg-3">

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span class="required">Digite o CPF do participante</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid" id="cpf_2" name="cpf_2" maxlength="14" onkeyup="mascara()">
                                        </div>

                                        <div class="col-lg-3">
                                            <br>

                                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                                <span></span>
                                            </label>
                                            <button type="submit" class="btn btn-primary" name="continuar" id="continuar">
                                                <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen043.svg-->
                                                <!--end::Svg Icon-->
                                                Continuar
                                            </button>



                                        </div>


                                    </div>


                                </div>



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

@include('../layout.footer')


<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script src="{{ url('assets/js/chartjs-plugin-datalabels.js') }}"></script>
<script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
        Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: msg
    });
    }
  </script>


</body>
<!--end::Body-->

</html>