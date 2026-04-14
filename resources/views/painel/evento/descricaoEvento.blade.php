@include('../layout.header')

<!--begin::Conteúdo-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">

            <div class="card mb-5 mb-xl-5">

                <div class="card-header border-0 pt-2">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Eventos DTEP</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Detalhes do Evento DTEP nº {{$evento->id}}</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{route("eventos.store")}}" class="btn btn-sm btn-light-primary"> Voltar</a>
                    </div>
                </div>

                <div class="card-body">

                    <strong>Nome: </strong>{{$evento->nome_evento}}<br>
                    <strong>Contato: </strong>{{$evento->email}}<br>
                    <strong>Data do Evento: </strong>
                    {{ date('d/m/Y', strtotime($evento->data_evento)) }}<br>
                    <strong>Local do Evento: </strong>{{--$evento->unidadeEvento()->first()->nome--}} <br>
                    <strong> Categoria do Evento: </strong>{{$evento->categoriaEvento()->first()->nome}} <br>
                    <strong>Publico Alvo: </strong>{{$evento->publico_alvo}}<br>
                    <strong>Situação do Evento: </strong> @if ($evento->status_evento == 'S') Sim @else Não @endif<br>
                    <strong>Quantidade de Vagas: </strong>{{$evento->vaga_evento}}<br>
                    <div>
                        <p class="text-lg-start"><strong>Descrição do Evento:</strong>{{$evento->evento}}</p>
                    </div>
                </div>
            </div>

            <!-- <div class="card mb-5 mb-xl-5">

                <div class="card-header border-0 pt-2">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Meus Eventos de PNR</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Visualize abaixo os seus Eventos</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="" class="btn btn-sm btn-light-primary">
                            < Voltar</a>
                    </div>
                </div>

            </div> -->



        </div>
    </div>
</div>

@include('layout.footer')

<link href="{{ url('assets/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ url('assets/js/datatables.bundle.js') }}"></script>




</body>
<!--end::Body-->

</html>