<!DOCTYPE html>
<html>

<style>
    .margin-logo {
        position: relative;

    }

    .title {
        margin-bottom: 6rem;
        margin: 0 auto;
    }
</style>

<head>
    <title>Relatório</title>
</head>

<body>

    <table border="0" cellspacing="0" cellpadding="0" style="width:100%; height: 0px">
        <tr>

            <img class="margin-logo" src="assets/imagens/logo.png" width="60">

            <td align="center" style="font-size: 20px">
                <h2 class="title">Hospital das Forças Armadas</h2>
            </td>
        </tr>

    </table>
    <br>
    <div style="font-family:arial; font-size: 12px">
        <table border="1" cellspacing="0" cellpadding="0" style="width:100%">
            <thead>
                <tr class="navbar-light" style="background-color: #000080">
                    <th style="width:20%" align="left"><span style="color: #ffffff;" > &nbsp;Nome</span></th>
                    <th style="width:20%" align="left"><span style="color: #ffffff;" > &nbsp;Evento</span></th>
                    <th style="width:10%"><span style="color: #ffffff">Conhecimeto</span></th>
                    <th style="width:10%"><span style="color: #ffffff">Inscrição</span></th>
                    <th style="width:10%"><span style="color: #ffffff">Participante?</span></th>
                    <th style="width:10%"><span style="color: #ffffff">Palestrante?</span></th>
                    <th style="width:10%"><span style="color: #ffffff">Organizador?</span></th>
                    <th style="width:10%"><span style="color: #ffffff">Ouvinte?</span></th>
                </tr>
            </thead>

            @php
                 $ordem = collect($inscrito)->sortBy('id');
            @endphp
            <tbody>
                 
                @foreach ( $ordem as $inscritos )

                <tr align="left">
                    <td>
                        &nbsp; {{$inscritos->nome}}
                    </td>
                    <td>
                        &nbsp; {{$inscritos->nome_evento}}
                    </td>
                    <td align="center">
                        {{$inscritos->conhecimento_evento_nome}}
                    </td>
                    <td align="center">
                        {{$inscritos->forma_inscricao_nome}}
                    </td>
                    <td align="center">
                        @if ( $inscritos->participante == 'S')
                        Sim
                        @else
                        Não
                        @endif
                    </td>
                    <td align="center">
                        @if ( $inscritos->palestrante == 'S')
                        Sim
                        @else
                        Não
                        @endif
                    </td>
                    <td align="center">
                        @if ( $inscritos->org_evento == 'S')
                        Sim
                        @else
                        Não
                        @endif
                    </td>
                    <td align="center">
                        @if ( $inscritos->ouvinte == 'S')
                        Sim
                        @else
                        Não
                        @endif
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</body>

</html>