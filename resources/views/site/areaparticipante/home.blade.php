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
    <h2 class="text-center">Área do Participante</h2>
    <div class="container-lg text-center">
        <span class="text-up-01">
            <p style="text-align: center;">Bem-Vindo {{session('nome')}}!</p>
            <p style="text-align: center;"> Aqui você encontrará os certificados de participação nos eventos que voce se inscreveu além de todos os arquivos referentes a cada evento.
            </p>
        </span>
        <br><br>
    </div>
</div>
<div class="container-sm">
    <br>
    <div class="container-fluid">
        <h2 class="text-center">Minhas Participações</h2>
    </div>
    @if(count($certificado)>0 )

    <div class="br-table" title="Minhas Participações">
        <table>
            <thead>

                <tr>
                    <th class="border-right border-bottom border-left border-top" style="text-align: left;" colspan="3" scope="rowgroup">Evento</th>
                </tr>

            </thead>
            <br>
            <tbody>
                @foreach ( $certificado as $certificados )
                <tr>
                    <td class="border-left">
                        <div class="row">
                            <div class="col-3 col-sm-3 col-lg-3 col-xl-3">
                                <div class="br-card">
                                    <div class="card-content">
                                        <img src="{{ asset('storage/'.$certificados->imagem) }} " alt="Imagem do evento" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-9 col-sm-9 col-lg-9 col-xl-9">
                                <br>
                                <p><label for="simples-input" class="text-up-01">{{$certificados->nome_evento}}</label></p>
                                <p><label for="simples-input"> Data: {{date('d/m/y', strtotime($certificados->data_evento ))}}</label></p>
                            </div>
                        </div>
                    </td>

                    <td class="border-bottom" style="align-items: right; text-align: center;">

                        @if ($certificados->certificado_autorizado == 'S' && $certificados->presenca == 'S')
                        @if ($certificados->eventos_certificados_id != null)
                        @if ($certificados->certificado_emitido == 'S')
                        <a class="br-button primary mr-3" type="button" href="{{route('participante.imprimirCertificado', ['id' => $certificados->id, 'participante_id' => $certificados->participante_id])}}"> Visualizar Certificados </a>
                        @else
                        <a class="br-button success mr-3" type="button" href="{{route('participante.emitirCertificado', ['id' => $certificados->id, 'participante_id' => $certificados->participante_id])}}"> Emitir Certificado </a>
                        @endif
                        @else
                        <img alt="Logo" src="{{ url('assets/imagens/ampulheta.png') }}" width="45px" style="margin-bottom: 5%;" /> <br> <label for="input-icon-small">Aguarde liberação  <br>do  certificado pela DTEP.</label>
                        @endif
                        @else
                        <img alt="Logo" src="{{ url('assets/imagens/ampulheta.png') }}" width="45px" style="margin-bottom: 5%;" /> <br> <label for="input-icon-small">Aguarde liberação  <br>do certificado pela DTEP.</label>
                        @endif
                    </td>

                    <td class="border-right border-bottom" style="align-items: right;">
                        <a class="br-button secondary mr-3" type="button" href="{{route('participante.emitirArquivo', $certificados->id )}}">Arquivos do Evento</a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>


    </div>
    @else
    <div class="container-lg text-center">
        <span class="text-up-01">
            <br>
            Nenhuma inscrição até o momento.
        </span><br><br><br>
    </div>
    @endif
</div>
@include('site.cadastro.js')
@include('site.participante.js')
<link rel="stylesheet" href="assets/node_modules/@govbr-ds/core/dist/core.css" />
<script src="assets/node_modules/@govbr-ds/core/dist/core.js"></script>



<br><br>


@include('site.site-layout.footer')


</html>