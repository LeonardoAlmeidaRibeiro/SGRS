<!DOCTYPE html>
<html>

<head>
    <title>Sistema de Eventos HFA</title>
    <style>
        .butt {
            border: 3px outset black;
            background-color: #c0c0c0;
            height: 39px;
            width: 123px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            text-decoration: underline;
        }

        .butt:hover {
            background-color: #a6a6a6;
            color: white;
        }

        .not-active {
            pointer-events: none;
            cursor: default;
        }
    </style>
</head>

<body>

    <p> Prezado(a) {{$fala_residente->nome}},</p>

    <p>O Departamento de Ensino e Pesquisa (DTEP) do HFA agrade a mensagem abaixo que você enviou:<br>
    <b><i>"{{$fala_residente->mensagem}}"</i></b></p>

    <p>Em resposta informamos que:<br>
    <b><i>"{{$resposta}}"</i></b></p>

    <p><b><font size=4>DTEP</font><br>
    Departamento de Ensino e Pesquisa do HFA<br>
    Por favor não responda esse e-mail.<br>
    Caso queira enviar uma nova mensagem acesse <a href="{{ route('falaResidente.index') }}">eventos.hfa.mil.br/falaResidente</a>.</b></p>

    <img class="logo" style="margin-left: auto; margin-right: auto;" alt="Logo" src="{{ url('assets/imagens/logo.png') }}" width="75px" />

</body>

</html>