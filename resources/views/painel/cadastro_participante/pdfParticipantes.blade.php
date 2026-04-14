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
    <title>Relatório de Participantes</title>
</head>

<body>

    <table border="0" cellspacing="0" cellpadding="0" style="width:100%; height: 0px">
        <tr>

            <img class="margin-logo" src="assets/imagens/logo.png" width="60">

            <td align="center" style="font-size: 20px">
                <h2 class="title">Hospital das Forças Armadas</h2>
                <h4 class="title">DTEP - Direção Técnica de Ensino e Pesquisa</h4>
            </td>
        </tr>

    </table>
    <br>
    <div style="font-family:arial; font-size: 12px">
        <table border="1" cellspacing="0" cellpadding="0" style="width:100%">
            <thead>
                <tr class="navbar-light" style="background-color: #000080">
                    <th style="width:30%"><span style="color: #ffffff">Nome</span></th>
                    <th style="width:20%"><span style="color: #ffffff">CPF</span></th>
                    <th style="width:15%"><span style="color: #ffffff">Telefone</span></th>
                    <th style="width:15%"><span style="color: #ffffff">E-mail</span></th>
                    <th style="width:15%"><span style="color: #ffffff">Tipo Pessoa</span></th>

                </tr>
            </thead>

            <tbody>
                @foreach ($participante as $participantes )
                <tr align="left">
                    <td>
                        &nbsp; {{$participantes->nome}}
                    </td>
                    <td align="center">
                        &nbsp; {{$participantes->cpf}}
                    </td>
                    <td align="center">
                        {{$participantes->telefone}}
                    </td>
                    <td align="center">
                        {{$participantes->email}}
                    </td>
                    <td align="center">
                    {{$participantes->tipo_pessoa}}
                    </td>
                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</body>

</html>