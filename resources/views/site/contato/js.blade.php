<script>
    const handlePhone = (event) => { 
        let input = event.target;
        input.value = phoneMask(input.value);
    };

    const phoneMask = (value) => {
        if (!value) return "";
        value = value.replace(/\D/g, "");
        value = value.replace(/(\d{2})(\d)/, "($1) $2");
        value = value.replace(/(\d)(\d{4})$/, "$1-$2");
        return value;
    };

    function salvar() {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var nome = $("#nome").val();
        var email = $("#email").val();
        var telefone = $("#telefone").val();
        var mensagem = $("#mensagem").val();

        if (nome == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Nome'
            });
            return false;
        }
        if (email == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo E-mail'
            });
            return false;
        }
        if (telefone == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Telefone'
            });
            return false;
        }
        var dados = {

            "nome": nome,
            "email": email,
            "telefone": telefone,
            "mensagem": mensagem,
            "g-recaptcha-response": grecaptcha.getResponse()
        }


        $("#enviarInscr").html('Aguarde...');
        $('#enviarInscr').prop('disabled', true); //Desabilita o botão

        
        $.ajax({
            url: "{{ route('contato.salvar') }}",
            type: "POST",
            data: dados,
            headers: headers,
            error: function(data) {
                console.log(data);
                if (data.status === 422) {

                    $("#enviarInscr").html('Enviar');
                    $('#enviarInscr').prop('disabled', false); //Habilita o botão novamente

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

                //console.log(data);

                var message = '';
                var success = '';

                $.each(data, function(campo, conteudo) {
                    if (campo == 'success') {
                        success = conteudo;
                    }
                    if (campo == 'message') {
                        message = conteudo;
                    }
                });

                if (success == true) {

                    $("#enviarInscr").html('Enviar');
                    $('#enviarInscr').prop('disabled', false); //Habilita o botão novamente

                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: message,
                    }).then(function() {
                        location.reload();
                    });

                } else {

                    $("#enviarInscr").html('Enviar');
                    $('#enviarInscr').prop('disabled', false); //Habilita o botão novamente

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: message,
                    });

                    return false;
                }

            }
        });

    }

    function abrirModalEditar(id) {

        var celula_a = $("#tr_" + id).text();
        var mensagem = $("#mensagem_tr" + id).val();
        $("#mensagem_edit").html(mensagem);

    }
</script>