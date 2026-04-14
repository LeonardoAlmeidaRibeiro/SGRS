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
    <title>Relação de Presença (Assinatura)</title>
</head>

<body>

    <table border="0" cellspacing="0" cellpadding="0" style="width:100%; height: 0px">
        <tr>

            <img class="margin-logo" src="assets/imagens/logo.png" width="60">

            <td align="center" style="font-size: 20px; font-family: Arial, Helvetica, sans-serif;">
                <h2 class="title"> Hospital das Forças Armadas</h2>
                <h4 class="title">DTEP - Direção Técnica de Ensino e Pesquisa</h4>
            </td>
        </tr>

    </table>
    <br><br>
    <div style="font-family:arial; font-size: 12px">
        <table border="0" cellspacing="0" cellpadding="0" style="width:100%; height: 0px">
            <tr>

                <td align="center" style="font-size: 20px; font-family: Arial, Helvetica, sans-serif;">
                    <h5 class="title">Relação de Presença (Assinatura): {{$eventos->nome_evento}}</h5>
                </td>
            </tr>
            <br>
        </table>
    </div>
    <div>
        <table border="1" cellspacing="0" cellpadding="0" style="width:100%; font-family: Arial, Helvetica, sans-serif;font-size: 12px">
            <thead>
                <tr class="navbar-light" style="background-color: #363636">
                    <th><span style="color: #ffffff;">Participante</span></th>
                    <th><span style="color: #ffffff">Tipo de Participação</span></th>
                    <th><span style="color: #ffffff">Data</span></th>
                    <th><span style="color: #ffffff">Assinatura</span></th>
                </tr>
            </thead>

            <tbody>

                @foreach ($inscricoes as $inscricao)
                @if($inscricao->evento_id == $eventos->id)
                <tr>
                    <td style="width:35%; height: 25px;">

                       <label style="font-family:arial; font-size: 10px" >{{$inscricao->participante()->first()->nome}}</label> 
                    </td>

                    <td style="width:35%">


                        @foreach($dados as $dado)

                        @if($inscricao->id == $dado['id'])

                        <label style="font-family:arial; font-size: 12px"> {{$dado['participacoes']}}</label> 

                        @endif

                        @endforeach

                        </a>
                    </td>
                    <td style="width:10%">
                        ___/___/____
                    </td>
                    <td style="width:25%">

                    </td>

                </tr>
                @endif
                @endforeach

            </tbody>


        </table>

    </div>

</body>

</html>