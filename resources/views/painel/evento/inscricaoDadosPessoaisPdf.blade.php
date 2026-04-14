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
    <title>Relação de Inscritos com Dados Pessoais</title>
</head>

<body>

    <table border="0" cellspacing="0" cellpadding="0" style="width:100%; height: 0px">
        <tr>

            <img class="margin-logo" src="assets/imagens/logo.png" width="60">

            <td align="center" style="font-size: 20px; font-family: Arial, Helvetica, sans-serif;">
                <h2 class="title">Hospital das Forças Armadas</h2>
                <h4 class="title">DTEP - Direção Técnica de Ensino e Pesquisa</h4>
            </td>
        </tr>
    </table>
    <br>
    <div style="font-family:arial; font-size: 12px">
        <table border="0" cellspacing="0" cellpadding="0" style="width:100%; height: 0px; font-family: Arial, Helvetica, sans-serif;"">
            <tr>

                <td align=" center" style="font-size: 20px; font-family: Arial, Helvetica, sans-serif;">
            <h5 class="title">Relação de Inscritos com Dados Pessoais: {{$evento->nome_evento}}</h5>
            </td>
            </tr>
            <br>
        </table>
    </div>
    <div style="font-family:arial; font-size: 12px">
        <table border="1" cellspacing="0" cellpadding="0" style="width:100%; font-family: Arial, Helvetica, sans-serif;font-size: 12px">
            <thead>
                <tr class="navbar-light" style="background-color: #363636">
                    <th align="left" style="width:40%"><span style="color: #ffffff">Nome</span></th>
                    <th style="width:12%"><span style="color: #ffffff">Tipo Pessoa</span></th>
                    <th style="width:12%"><span style="color: #ffffff">Telefone</span></th>
                    <th style="width:25%"><span style="color: #ffffff">E-mail</span></th>
                    <th style="width:15%"><span style="color: #ffffff">Presença</span></th>
                </tr>
            </thead>

            <tbody>

                @foreach ( $inscrito as $inscritos )


                <tr align="left">
                    <td style="height: 25px;">
                    <label style="font-family:arial; font-size: 10px;" > {{$inscritos->nome}}</label> 
                    </td>
                    <td align="center">
                    <label style="font-family:arial; font-size: 10px" > {{$inscritos->tipo_pessoa}}</label> 
                    </td>
                    <td align="center">
                    <label style="font-family:arial; font-size: 10px" > {{$inscritos->telefone}}</label> 
                    </td>
                    <td align="center">
                    <label style="font-family:arial; font-size: 10px" >  {{$inscritos->email}}</label> 
                    </td>
                    <td align="center">
                        @if ($inscritos->presenca == 'S')
                        <label style="font-family:arial; font-size: 10px" >  Presente</label> 
                        @else
                        <label style="font-family:arial; font-size: 10px" >  Ausente</label> 
                        @endif
                    </td>
                </tr>
                @endforeach


            </tbody>

        </table>

    </div>

</body>

</html>