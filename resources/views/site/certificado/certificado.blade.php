@include('site.site-layout.header')

<div class="container-lg mt-4">
    <div class="br-breadcrumb">
        <ul class="crumb-list">
            <li class="crumb home"><a class="br-button circle" href="{{ route('site.index')}}">
                    <span class="sr-only">Página inicial</span><i class="fas fa-home"></i></a>
            </li>
            <li class="crumb" data-active="active"><i class="icon fas fa-chevron-right"></i><a href="{{ route('participante.areaParticipante')}}">Área do Participante</a>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid" style="background-color: #F3F3F3;">
    <h2 class="text-center">Certificado Válido</h2>
    <div class="container-lg text-center">
        <span class="text-up-01">
            <p style="text-align: center;"></p>
            <p style="text-align: center;"> Confira abaixo se o certificado consultado é um certificado válido. </p>
        </span>
        <br><br>
    </div>
</div>
<br><br><br>
@if($validade != null)
<div class="container-fluid">
    <div>
        <fieldset class="border-solid-sm rounder-md p-4">
            <legend class="text-up-02">Validação de Certificado</legend>
            <div>

                <div class="row  justify-content-center">
                    <div class="header-logo"><img src="{{ url('assets/imagens/logo.png') }}" alt="logo" width="90" />
                        <span class="br-divider vertical"></span>
                    </div>
                </div>
                <div class="row  justify-content-center">
                    <h2>
                        <font color="#168821">Certificado Válido!</font>&nbsp;<img src="{{ url('assets/imagens/check.png') }}" width="45" height="45" style="margin-bottom: 4%;" />
                    </h2>
                </div>

                <div class="row  justify-content-center">
                    <div style="color:#168821" class=" text-up-02">
                        Certificamos que <strong><u>{{$validade->nome}}</u></strong> possuí um certificado válido com os seguintes dados:
                    </div>
                </div>

                <div class="row  justify-content-center">
                    <h3>
                        {{$validade->nome_no_certificado}}
                    </h3>
                </div>

                <div class="row  justify-content-center">
                    <div class="text-weight-semi-bold text-up-02">Evento: &nbsp;</div>
                    <div class="text-weight text-up-02"> {{$validade->nome_evento}}</div>
                </div>

                <div class="row  justify-content-center">
                    <div class="text-weight-semi-bold text-up-02">Data: &nbsp; </div>
                    <div class="text-weight text-up-02"> {{date('d/m/Y', strtotime($validade->data_evento))}} </div>
                </div>

                <div class="row  justify-content-center">
                    <div class="text-weight-semi-bold text-up-02"> Carga Horária:&nbsp;</div>
                    <div class="text-weight text-up-02"> {{$validade->carga_horaria}}</div>
                </div>

                <div class="row  justify-content-center">
                    <div class="text-weight-semi-bold text-up-02 mr-1">Tipo de Participação: </div>
                    <div class="text-weight text-up-02"> {{$validade->tipo_certificado}}</div>
                </div>

            </div>
            <br><br>
        </fieldset>
    </div>
</div>
@else

<div class="container-fluid">
    <div>
        <fieldset class="border-solid-sm rounder-md p-4">
            <legend class="text-up-02">Validação de Certificado</legend>
            <div>
                <div class="row  justify-content-center">
                    <div class="header-logo"><img src="{{ url('assets/imagens/logo.png') }}" alt="logo" width="90" />
                        <span class="br-divider vertical"></span>
                    </div>
                </div>
                <div class="row  justify-content-center">

                    <h2>
                        <font color="#d11507">Certificado não Identificado!</font>&nbsp;<img src="{{ url('assets/imagens/cross.png') }}" width="45" height="45" style="margin-bottom: 4%;" />
                    </h2>
                </div>
                <div class="row  justify-content-center">
                    <div class="text-weight-semi-bold text-up-02">
                        Infelizmente, não conseguimos validar o certificado fornecido.
                    </div>
                </div>
                <div class="row  justify-content-center">
                    <div class="text-weight-semi-bold text-up-02">
                        Por favor, entre em contato com DTEP - Direção Técnica de Ensino e Pesquisa.
                    </div>
                </div>
            </div>
            <br><br>
    </div>

    </fieldset>
</div>
</div>
@endif
<br><br>
@include('site.cadastro.js')
@include('site.site-layout.footer')


</html>