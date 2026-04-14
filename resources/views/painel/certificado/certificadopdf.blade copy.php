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
    .abs {
        position: absolute;
        bottom: 0;
        top: 9%;
        right: 43%;
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

<body>

    <div style="page-break-after:always;">
        <div class="clearfix">
            <div class="linha_1"></div>

            <div class="img-container">
                <img src="{{ url('assets/imagens/logo.png') }}" width="100%" />
            </div>
            <div class="img-container1">
                <img src="{{ url('assets/imagens/frente_11.png') }}" width="100%" />
            </div>
        </div>

        <div class="abs" style="text-align: start">
            <div style="color: red;">
                <div style="font-size:2rem">Ministério da Defesa</div>
                <div style="font-size:2rem">Hospital das Forças Armadas</div>
                
            </div>
            <div style="font-size:4rem; color:red">Certificado</div>
        </div>

        <div class="abs1" style="width: 70%;">
            <div>
                @if(isset($texto))
                    <?php echo $texto?>
                @endif
            </div>
            @if(isset($inscricao->emitido_em))
                <div style="margin-top:2%;"><strong>Brasília-DF, {{ strftime('dia %d de %B de %Y', strtotime($inscricao->emitido_em)) }}.</strong> </div>
            @endif
        </div>

        <div style="text-align: center; width:100%; ">
            <div class="ck-content" style="position:absolute;left:180;top:400;width:200;height:501;">
                @if(isset($certificado_evento->first()->assinatura_1))
                    <?php  echo $certificado_evento->first()->assinatura_1?>
                @endif
            </div>
            <div class="ck-content" style="position:absolute;left:385;top:400;width:200;height:501;">
                @if(isset($certificado_evento->first()->assinatura_2))
                    <?php  echo $certificado_evento->first()->assinatura_2?>
                @endif
            </div>
            <div class="ck-content" style="position:absolute;left:600;top:400;width:200;height:501;">
                @if(isset($certificado_evento->first()->assinatura_3))
                    <?php  echo $certificado_evento->first()->assinatura_3?>
                @endif
            </div>
        </div>

    </div>
    <div></div>
    <div>
        <div style="margin-top: 5%; margin-left: 5%;">
            <div style="position: absolute; width: 50%;">
                @if(isset($certificado_evento->first()->conteudo_programatico))
                    <?php  echo $certificado_evento->first()->conteudo_programatico?> 
                @endif
            </div>
            <div style="position:absolute; right: 30px; width:40%">
                @if(isset($certificado_evento->first()->texto_verso))
                    <?php  echo $certificado_evento->first()->texto_verso?>
                @endif
            </div>

        </div>
        <div>
            <div class="ck-content" style="position:absolute; right: 100px; width:200; top: 300px;">
                @if(isset($certificado_evento->first()->assinatura_verso))
                <?php  echo $certificado_evento->first()->assinatura_verso?>
                @endif
            </div>
        </div>
        <div class="linha_2"></div> 
        <div class="img-container2">
            <img src="{{ url('assets/imagens/logo.png') }}" width="100%" />
        </div>
        <div style="position: absolute; left:12%; bottom:6%;">
            <div>CERTIFICADO REGISTRADO NO LIVRO N° {{$certificado_evento->first()->livro}}. FOLHA N° {{$certificado_evento->first()->folha}}, DA A SUBDIVISÃO DE CAPACITAÇÃO.</div>
            <div>BRASÍLIA-DF, @if(isset($certificado_evento->first()->data_livro)){{ strftime('dia %d de %B de %Y', strtotime($certificado_evento->first()->data_livro)) }} @endif</div>
            <div>Endereço para validação do certificado: <strong> https://eventos.hfa.mil.br/validarCertificado-{{$criptografia}} </strong></div>
        </div>
        <div style="position: absolute; right: 60px; bottom:3%;">
            <img src="data:image/png;base64, {!! base64_encode(QrCode::size(80)->generate('https://eventos.hfa.mil.br/validarCertificado-{{$criptografia}}')); !!}">
        </div>
    <div>

</body>

</html>
