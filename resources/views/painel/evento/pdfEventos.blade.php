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
    <title>Relatório de Eventos</title>
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
                    <th style="width:10%"><span style="color: #ffffff">nº</span></th>
                    <th style="width:30%"><span style="color: #ffffff">Evento</span></th>
                    <th style="width:15%"><span style="color: #ffffff">Data</span></th>
                    <th style="width:15%"><span style="color: #ffffff">Status</span></th>
                    <th style="width:15%"><span style="color: #ffffff">Categoria</span></th>
                    <th style="width:20%"><span style="color: #ffffff">Público Alvo</span></th>
                    <th style="width:15%"><span style="color: #ffffff">Vagas</span></th>
                    <th style="width:20%"><span style="color: #ffffff">Carga Horária</span></th>
                    <th style="width:30%"><span style="color: #ffffff">E-mail</span></th>
                    <th style="width:20%"><span style="color: #ffffff">Local</span></th>
                    <th style="width:15%"><span style="color: #ffffff">Vídeo</span></th>
                </tr>
            </thead>

            <tbody>
                @php
                $dados = collect($evento)->sortBy('id');
                @endphp
            <tbody>
                @foreach ($dados as $eventos )

                <tr align="center">
                    <td>
                        {{$eventos['id']}}
                    </td>
                    <td align="left">
                        &nbsp;{{$eventos['nome_evento']}}
                    </td>
                    <td align="center">
                        {{$eventos['data_evento']}}
                    </td>
                    <td align="center">
                        @if ($eventos['status_evento'] == 'S')
                        Ativo
                        @else
                        Inativo
                        @endif
                    </td>
                    <td align="center">
                        {{$eventos['categoria_evento_id']}}
                    </td>
                    <td align="center">
                        {{$eventos['publico_alvo']}}
                    </td>
                    <td align="center">
                        {{$eventos['vaga_evento']}}
                    </td>
                    <td align="center">
                        {{$eventos['carga_horaria']}}
                    </td>
                    <td align="center">
                        {{$eventos['email']}}
                    </td>
                    <td>
                        {{$eventos['unidade_evento_id']}}
                    </td>
                    <td>
                        {{$eventos['video'] ?? 'Nenhum vídeo cadastrado.'}}
                    </td>
                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</body>

</html>