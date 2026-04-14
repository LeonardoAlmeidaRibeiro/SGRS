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

    <p> Prezado(a), {{$participante->nome}}</p>

    <p>Acesse o link abaixo para redefinir sua senha.</p>
    <a href="{{ route('updateSenha.index', $token)}}">Acesse Aqui!</a>
    <p>Fique atento o link irá expirar em 30 minutos.</p>
    
    <p><b><font size=4>DTEP</font><br>
    Departamento de Ensino e Pesquisa do HFA<br>
    Por favor não responda esse e-mail.<br>
    
    <img class="logo" style="margin-left: auto; margin-right: auto;" alt="Logo" src="{{ $message->embed('assets/imagens/logo.png') }}" width="75px" />

</body>

</html>