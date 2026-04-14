<!DOCTYPE html>
<html>

<link rel="stylesheet" href="{{ url('/assets/css/content-styles.css')}}" type="text/css">

<style>
    * {
        margin: 0;
        padding: 0;
    }

    .linha_1 {
        position: fixed;
        border-left: 5px solid red;
        width: 100%;
        top: 5%;
        bottom: 5%;
        left: 228px;
        right: 0;
    }
    
    .linha_2 {
        position: fixed;
        border-bottom: 5px solid red;
        width: 94.5%;
        bottom: 15%;
        left: 30px;
        right: 0px;
    }

    .assinatura {
        margin: 2rem;
    }

    .img-container {
        width: 12%;
        position: absolute;
        top: 10%;
        left: 5%;

    }

    .img-container1 {
        width: 20%;
        position: absolute;
        bottom: 10%;
        left: 0;
    }
    .img-container2 {
        width: 5%;
        position: absolute;
        bottom: 4%;
        left: 5%;
    }
    .img-container3 {
        width: 27%;
        position: absolute;
        top: 7%;
        right: 5%;
    }
    .abs {
        position: absolute;
        bottom: 0;
        top: 9%;
        right: 42%;
    }

    .abs1 {
        position: absolute;
        bottom: 0;
        top: 35%;
        left: 23%; 
    }

    .abs2 {
        position: absolute;
        bottom: 5%;
    }

    table {
        border-collapse: collapse;
    }

    td,th {
        border: 2px solid black;
        padding: 0.2rem;
    }

</style>
<head>
    <title>Certificado</title>
</head>

<body>

    <div style="page-break-after:always;">
        <div class="clearfix">
            <div class="linha_1"></div>

            <div class="img-container">
                <img src="{{ url('assets/imagens/logo.png') }}" width="73" height="92" />
            </div>
            <div class="img-container3">
                <div class="ck-content" style="height:145px;">
                    @if(isset($certificado_evento->first()->logo_superior))
                        <?php  echo $certificado_evento->first()->logo_superior?>
                    @endif
                </div>
            </div>
            <div class="img-container1">
                <img src="{{ url('assets/imagens/frente_11.png') }}" width="100%" />
            </div>
        </div>

        <div class="abs" style="text-align: start">
            <div style="color: red;">
                <div style="font-size:1.5rem">MINISTÉRIO DA DEFESA</div>
                <div style="font-size:1.5rem">HOSPITAL DAS FORÇAS ARMADAS</div>
            </div>
            <div style="font-size:3rem; color:red; margin-top:20px">CERTIFICADO</div>
        </div>

        <div class="abs1" style="width: 70%;">
            <div class="ck-content" style="line-height: 2">
                @if(isset($texto))
                    <?php echo $texto?>
                @endif
            </div>
            @if(isset($inscricao->emitido_em))
                <div style="font-size:1.2rem; position:absolute;left:5; top:180;">
                    Brasília-DF, {{ strftime('dia %d de %B de %Y', strtotime($inscricao->emitido_em)) }}.
                </div>
            @else
                <div style="font-size:1.2rem; position:absolute;left:5; top:180;">
                    Brasília-DF, {{ strftime('dia %d de %B de %Y') }}.
                </div>
            @endif
        </div>

        <div style="text-align: center; width:100%; ">
            <div class="ck-content" style="position:absolute; left:180; top:430; width:180; height:100px;">
                @if(isset($certificado_evento->first()->assinatura_1))
                    <?php  echo $certificado_evento->first()->assinatura_1?>
                @endif
            </div>
            <div class="ck-content" style="position:absolute; left:400; top:430; width:180; height:100px;">
                @if(isset($certificado_evento->first()->assinatura_2))
                    <?php  echo $certificado_evento->first()->assinatura_2?>
                @endif
            </div>
            <div class="ck-content" style="position:absolute; left:580; top:430; width:250; height:100px;">
                @if(isset($certificado_evento->first()->assinatura_3))
                    <?php  echo $certificado_evento->first()->assinatura_3?>
                @endif
            </div>
        </div>

    </div>
    <!-- verso -->
    <div>
        <div style="margin-top: 5%; margin-left: 5%;">
            <div class="ck-content" style="position: absolute; width: 50%;">
                @if(isset($personalizados->first()->frente) != null)
                    <?php  echo $personalizados->first()->verso?>
                @elseif(isset($certificado_evento->first()->conteudo_programatico))
                    <?php  echo $certificado_evento->first()->conteudo_programatico?> 
                @endif
            </div>
            <div style="position:absolute; @if(isset($personalizados->first()->verso) == null && isset($personalizados->first()->frente) != null) left:30%; width:40% @else right: 30px; width:40%; @endif">
                @if(isset($certificado_evento->first()->texto_verso))
                    <?php  echo $certificado_evento->first()->texto_verso?>
                @endif
            </div>
        </div>
        
        <div>
            <div class="ck-content" style="position:absolute; @if(isset($personalizados->first()->verso) == null && isset($personalizados->first()->frente) != null) left:37%; width:220; top: 300px; @else right: 100px; width:220; top: 300px; @endif">
                @if(isset($certificado_evento->first()->assinatura_verso))
                    <?php  echo $certificado_evento->first()->assinatura_verso?>
                @endif
            </div>
        </div>
        <div>
            @if(isset($certificado_evento->first()->logos_inferiores))
                <div style="width: 10%; left:13%; bottom:17%; position: absolute;">
                    <span><strong> APOIO E ORGANIZAÇÂO:</strong></span>
                </div>
                <div class="ck-content" style="position:absolute; width:1100px; bottom:13%; align:left; left:5% height:120px;">
                    <?php  echo $certificado_evento->first()->logos_inferiores?>
                </div>
            @endif
        </div>
        
        <div class="linha_2"></div> 
        <div class="img-container2">
            <img src="{{ url('assets/imagens/logo.png') }}" width="100%" />
        </div>
        <div style="position: absolute; left:12%; bottom:6%;">
            <div>CERTIFICADO REGISTRADO NO LIVRO N° @if(isset($certificado_evento->first()->livro)) {{$certificado_evento->first()->livro}} @endif . FOLHA N° @if(isset($certificado_evento->first()->folha)){{$certificado_evento->first()->folha}} @endif, DA SUBDIVISÃO DE CAPACITAÇÃO.</div>
            <div>BRASÍLIA-DF, @if(isset($certificado_evento->first()->data_livro)){{ strftime('dia %d de %B de %Y', strtotime($certificado_evento->first()->data_livro)) }} @endif</div>
            <div>Endereço para validação do certificado: <strong> https://eventos.hfa.mil.br/validarCertificado-@if(isset($criptografia)){{$criptografia}}@endif </strong></div>
        </div>
        <div style="position: absolute; right: 60px; bottom:3%;">
            <img src="data:image/png;base64, {!! base64_encode(QrCode::size(80)->generate('https://eventos.hfa.mil.br/validarCertificado-@if(isset($criptografia)){{$criptografia}}@endif')); !!}">
        </div>
    <div>

</body>

</html>
