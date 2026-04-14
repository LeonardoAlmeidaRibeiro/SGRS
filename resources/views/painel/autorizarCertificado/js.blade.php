<script>
    function Autorizar(id) {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var autorizacao = $("#autorizacao" + id).val();
        var data_evento = $("#data_evento" + id).val();
        
        const dataAtual = new Date();
        const ano = dataAtual.getFullYear();
        const mes = (dataAtual.getMonth() + 1).toString().padStart(2, '0');
        const dia = dataAtual.getDate().toString().padStart(2, '0');
        const dataFormatada = `${ano}-${mes}-${dia}`;

        if (dataFormatada <= data_evento) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O evento ainda não ocorreu para ser autorizado!'
            });
            return false
        }

        $.ajax({
            url: "{{ route('autorizarCertificados.update', '') }}/" + id,
            type: "POST",
            data: "&autorizacao=" + autorizacao,
            headers: headers,
            error: function(data) {

                if (data.status === 422) {
                    var message = '';
                    $.each(data.responseJSON.errors, function(campo, conteudo) {
                        message = message.concat(conteudo);
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: message
                    });
                }
            },
            success: function(data) {

                var message = '';
                var success = '';
                var id = '';
                var certificado_autorizado = '';
                var autorizado_em = '';

                $.each(data, function(campo, conteudo) {
                    if (campo == 'success') {
                        success = conteudo;
                    }
                    if (campo == 'message') {
                        message = conteudo;
                    }
                    if (campo == 'id') {
                        id = conteudo;
                    }
                    if (campo == 'certificado_autorizado') {
                        certificado_autorizado = conteudo;
                    }
                    if (campo == 'autorizado_em') {
                        autorizado_em = conteudo;
                    }

                });

                if (success == true) {

                    var botaoAutorizar = '';
                    botaoAutorizar = botaoAutorizar + '<div class="card-toolbar">' +
                        '<a class="btn btn-sm btn-light-success" onclick="Autorizar(' + id + ')" >' +
                        '<i class="fas fa-duotone fa-lock fs-1"></i>' +
                        'Autorizar' +
                        '</a>  ' +
                        '<a href="{{ route("participantes.index", "") }}/' + id + '" class="btn btn-sm btn-light-primary">' +
                        '<i class="fas fa-duotone fa-users fs-1"></i>' +
                        'Participantes' +
                        '</a>' +
                        '</div>';

                    var botaoCancelar = '';
                    botaoCancelar = botaoCancelar + '<div class="card-toolbar">' +
                        '<a  class="btn btn-sm btn-light-Danger" onclick="Autorizar(' + id + ')" >' +
                        '<i class="fas fa-duotone fa-lock-open fs-1"></i>' +
                        'Cancelar' +
                        '</a> ' +
                        '<a href="{{ route("participantes.index", "") }}/' + id + '" class="btn btn-sm btn-light-primary" >' +
                        '<i class="fas fa-duotone fa-users fs-1"></i>' +
                        'Participantes' +
                        '</a>' +
                        '</div>';

                    if (certificado_autorizado == 'S') {
                        var autorizacao_texto = 'Sim';
                        // quando aparece não em autorizado tem que aparecer o botão para cancelar autorização
                        var botoes = botaoCancelar;
                        message = 'Evento Autorizado.'
                    } else {
                        var autorizacao_texto = 'Não';
                        // quando aparece não em autorizado tem que aparecer o botão para autorizar
                        var botoes = botaoAutorizar;
                        message = 'Removido Autorização.'

                    }

                    if (autorizado_em != null) {
                        var data = new Date(autorizado_em);
                        autorizado_em_texto = data.toLocaleDateString('pt-BR', {
                            timeZone: 'UTC'
                        });
                    } else {
                        var autorizado_em_texto = '-';
                    }

                    $('#autorizacao' + id).val(certificado_autorizado);
                    $("#celula_e_" + id).html(autorizacao_texto);
                    $("#celula_f_" + id).html(autorizado_em_texto);
                    $("#botao_acoes_" + id).html(botoes);

                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: message
                    });
                }

            }
        });
    }
</script>