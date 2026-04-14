<script>
    function executarCriar() {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var nome = $("#nome").val();
        var escolaridade = $("#escolaridade").val();
        var cpf = $("#cpf").val();
        var cep = $("#cep").val();
        var cidade_uf = $("#cidade_uf").val();
        var endereco = $("#endereco").val();
        var complemento = $("#complemento").val();
        var genero = $("#genero").val();
        var email = $("#email").val();
        var senha = $("#senha").val();
        var senha_2 = $("#senha_2").val();
        var telefone = $("#telefone").val();
        var tipo_pessoa = $("#tipo_pessoa").val();
        var genero = $("#genero").val();
        var forca = $("#forca").val();
        var estado_civil = $("#estado_civil").val();
        var qas_qms = $("#qas_qms").val();
        var posto_graduacao = $("#posto_graduacao").val();
        var bairro = $("#bairro").val();
        var qualificacao = $("#qas_qms").val();
        var especialidade = $("#especialidade").val();
        var status_militar = $("#status_militar").val();
        var categoria_profissional_id = $("#categoria_profissional_id").val();
        if (tipo_pessoa == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Tipo Pessoa'
            });
            return false;
        }

        if (tipo_pessoa == "Outro") {

            if (senha == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Preencha o campo preencha o campo senha'
                });
                return false;
            }

            if (senha_2 == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Por favor confirme a senha'
                });
                return false;
            }

        }

        if (cpf == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo CPF'
            });
            return false;
        }

        if (nome == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Nome'
            });
            return false;
        }

        if (categoria_profissional_id == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Categoria Profissional'
            });
            return false;
        }

        if (cep == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo CEP'
            });
            return false;
        }

        if (genero == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Genêro'
            });
            return false;
        }

        if (estado_civil == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Estado Civil'
            });
            return false;
        }

        if (escolaridade == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Escolaridade'
            });
            return false;
        }

        if (email == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Email'
            });
            return false;
        }

        if (cidade_uf == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Cidade/UF'
            });
            return false;
        }

        if (endereco == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Endereço'
            });
            return false;
        }

        if (complemento == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Complemento'
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

        if (senha == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Senha'
            });
            return false;
        }

        if (senha_2 == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Confirmar Senha'
            });
            return false;
        }

        if (senha_2 != senha) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Os campos de senha devem ser iguais!'
            });
            return false;
        }

        $("#salvarCadastro").html('Aguarde...');
        $('#salvarCadastro').prop('disabled', true); //Desabilita o botão

        var dados = {

            "nome": nome,
            "cpf": cpf,
            "email": email,
            "telefone": telefone,
            "estado_civil": estado_civil,
            "genero": genero,
            "qualificacao": qualificacao,
            "endereco": endereco,
            "complemento": complemento,
            "bairro": bairro,
            "cidade_uf": cidade_uf,
            "cep": cep,
            "forca": forca,
            "posto_graduacao": posto_graduacao,
            "qas_qms": qas_qms,
            "escolaridade": escolaridade,
            "senha": senha,
            "senha_2": senha_2,
            "qas_qms": qas_qms,
            "tipo_pessoa": tipo_pessoa,
            "especialidade": especialidade,
            "status_militar": status_militar,
            "categoria_profissional_id": categoria_profissional_id

        }

        console.log(dados);

        $.ajax({
            url: "{{ route('cadastroParticipante.store') }}",
            type: "POST",
            data: dados,
            headers: headers,
            error: function(data) {
                //console.log(data);
                if (data.status === 422) {

                    $("#salvarCadastro").html('Salvar');
                    $('#salvarCadastro').prop('disabled', false); //Habilita o botão novamente

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
                console.log(data);

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

                    $("#salvarCadastro").html('Salvar');
                    $('#salvarCadastro').prop('disabled', false); //Habilita o botão novamente

                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: "Participante salvo com sucesso!"
                    }).then(function() {
                        window.location = "{{ route('participantes') }}";
                    });

                } else {

                    $("#salvarCadastro").html('Salvar');
                    $('#salvarCadastro').prop('disabled', false); //Habilita o botão novamente

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: message
                    });
                }

            }
        });

    }

    function mostrarCampos() {

        var tipo_pessoa = $("#tipo_pessoa").val();


        if (tipo_pessoa == "Outro Civil" || tipo_pessoa == "Civil") {

            $("#forca_id").hide();
            $("#qualificacao_id").hide();
            $("#especialidade_id").hide();
            $("#posto_id").hide();
            $("#status_id").hide();

        } else {
            $("#forca_id").show();
            $("#qualificacao_id").show();
            $("#especialidade_id").show();
            $("#posto_id").show();
            $("#status_id").show();
        }
    }

    function mostrarCamposEdit() {

        var tipo_pessoa = $("#tipo_pessoa_edit").val();

        console.log(tipo_pessoa);


        if (tipo_pessoa == "Outro Civil" || tipo_pessoa == "Civil") {

            $("#forca_id_edit").hide();
            $("#qualificacao_id_edit").hide();
            $("#especialidade_id_edit").hide();
            $("#posto_id_edit").hide();
            $("#status_id_edit").hide();

        } else {
            $("#forca_id_edit").show();
            $("#qualificacao_id_edit").show();
            $("#especialidade_id_edit").show();
            $("#posto_id_edit").show();
            $("#status_id_edit").show();
        }
    }

    function executarEditar(id) {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var nome = $("#nome_edit").val();
        var escolaridade = $("#escolaridade_edit").val();
        var cpf = $("#cpf_edit").val();
        var cep = $("#cep_edit").val();
        var cidade_uf = $("#cidade_uf_edit").val();
        var endereco = $("#endereco_edit").val();
        var complemento = $("#complemento_edit").val();
        var genero = $("#genero_edit").val();
        var email = $("#email_edit").val();
        var senha = $("#senha_edit").val();
        var senha_2 = $("#senha_2_edit").val();
        var telefone = $("#telefone_edit").val();
        var tipo_pessoa = $("#tipo_pessoa_edit").val();
        var escolaridade = $("#escolaridade_edit").val();
        var genero = $("#genero_edit").val();
        var forca = $("#forca_edit").val();
        var estado_civil = $("#estado_civil_edit").val();
        var qas_qms = $("#qas_qms_edit").val();
        var posto_graduacao = $("#posto_graduacao_edit").val();
        var bairro = $("#bairro_edit").val();
        var qualificacao = $("#qas_qms_edit").val();
        var especialidade = $("#especialidade_edit").val();
        var status_militar = $("#status_militar_edit").val();
        var categoria_profissional_id = $("#categoria_profissional_id").val();
        

        if (tipo_pessoa == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Tipo Pessoa'
            });
            return false;
        }

        if (cpf == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo CPF'
            });
            return false;
        }

        if (nome == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Nome'
            });
            return false;
        }

        if (cep == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo CEP'
            });
            return false;
        }

        if (genero == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Genêro'
            });
            return false;
        }

        if (estado_civil == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Estado Civil'
            });
            return false;
        }

        if (escolaridade == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Escolaridade'
            });
            return false;
        }

        if (email == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Email'
            });
            return false;
        }

        if (cidade_uf == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Cidade/UF'
            });
            return false;
        }

        if (endereco == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Endereço'
            });
            return false;
        }

        if (bairro == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Bairro'
            });
            return false;
        }

        if (complemento == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Complemento'
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


        if (senha_2 != senha) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Os campos de senha devem ser iguais!'
            });
            return false;
        }

        var dados = {

            "nome": nome,
            "cpf": cpf,
            "email": email,
            "telefone": telefone,
            "estado_civil": estado_civil,
            "genero": genero,
            "qualificacao": qualificacao,
            "endereco": endereco,
            "complemento": complemento,
            "bairro": bairro,
            "cidade_uf": cidade_uf,
            "cep": cep,
            "forca": forca,
            "posto_graduacao": posto_graduacao,
            "qas_qms": qas_qms,
            "escolaridade": escolaridade,
            "senha": senha,
            "senha_2": senha_2,
            "qas_qms": qas_qms,
            "tipo_pessoa": tipo_pessoa,
            "especialidade": especialidade,
            "status_militar": status_militar,
            "categoria_profissional_id":categoria_profissional_id,

        }

        $("#editarCadastro").html('Aguarde...');
        $('#editarCadastro').prop('disabled', true); //Desabilita o botão

        $.ajax({
            url: "{{ route('cadastroParticipante.update', '') }}/" + id,
            type: "PUT",
            data: dados,
            headers: headers,
            error: function(data) {
                //console.log(data);

                $("#editarCadastro").html('Salvar');
                $('#editarCadastro').prop('disabled', false); //Habilita o botão novamente

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
                console.log(data);

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
                    $("#editarCadastro").html('Salvar');
                    $('#editarCadastro').prop('disabled', false); //Habilita o botão novamente
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: "Participante editado com sucesso!"
                    }).then(function() {
                        window.location = "{{ route('participantes') }}";
                    });

                } else {
                    $("#editarCadastro").html('Salvar');
                    $('#editarCadastro').prop('disabled', false); //Habilita o botão novamente
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',

                    });
                }

            }
        });

    }

    function verificarCpf(){
        var cpf = $("#cpf_2").val();

        if(cpf == ''){
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Preencha o campo CPF!' });
            return false;
    }
        $("#continuar").html('Aguarde...');
        $('#continuar').prop('disabled', true); //Desabilita o botão
    }

    function api() {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }


        var cpf = $("#cpf_2").val();

        var dados = {
            'cpf': cpf,
        };

        $.ajax({
            url: "{{ route('dadosParticipantes.index') }}",
            type: "GET",
            data: dados,
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
                console.log(data);


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



            }
        });

    }



    function dados() {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        // window.location = "{{ route('cadastroParticipante.index') }}";

        var cpf = $("#cpf").val();

        dados = {
            "cpf": cpf,
        };

        $.ajax({
            url: "{{ route('dadosParticipantes.index') }}",
            type: "GET",
            data: dados,
            headers: headers,
            error: function(data) {
                //console.log(data);
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

                console.log(data);

                var nome = '';
                var email = '';
                var data_nascimento = '';
                var telefone = '';
                var genero = '';
                var tipo_pessoa = '';
                var cep = '';
                var cidade = '';
                var estado = '';
                var endereco = '';
                var bairro = '';
                var complemento = '';
                var escolaridade = '';
                var estado_civil = '';
                var posto_graduacao_id = '';
                var especialidade = '';
                var qualificacoes_id = '';
                var status_militar_id = '';
                var forca_id = '';
                var exists = '';
                var success = '';

                $.each(data, function(campo, conteudo) {

                    if (campo == 'nome') {
                        nome = conteudo;
                    }

                    if (campo == 'email') {
                        email = conteudo;
                    }

                    if (campo == 'data_nascimento') {
                        data_nascimento = conteudo;
                    }

                    if (campo == 'telefone') {
                        telefone = conteudo;
                    }

                    if (campo == 'genero') {
                        genero = conteudo;
                    }

                    if (campo == 'tipo_pessoa') {
                        tipo_pessoa = conteudo;
                    }

                    if (campo == 'cep') {
                        cep = conteudo;
                    }

                    if (campo == 'cidade') {
                        cidade = conteudo;
                    }

                    if (campo == 'estado_civil') {
                        estado_civil = conteudo;
                    }

                    if (campo == 'endereco') {
                        endereco = conteudo;
                    }

                    if (campo == 'bairro') {
                        bairro = conteudo;
                    }

                    if (campo == 'complemento') {
                        complemento = conteudo;
                    }

                    if (campo == 'numero') {
                        numero = conteudo;
                    }

                    if (campo == 'escolaridade') {
                        escolaridade = conteudo;
                    }

                    if (campo == 'posto_graduacao_id') {
                        posto_graduacao_id = conteudo;
                    }

                    if (campo == 'forca_id') {
                        forca_id = conteudo;
                    }

                    if (campo == 'status_militar_id') {
                        status_militar_id = conteudo;
                    }

                    if (campo == 'qualificacoes_id') {
                        qualificacoes_id = conteudo;
                    }

                    if (campo == 'especialidade') {
                        especialidade = conteudo;
                    }

                    if (campo == 'exists') {
                        exists = conteudo;
                    }

                    if (campo == 'success') {
                        success = conteudo;
                    }

                });

                if (success == true) {

                    console.log('oi');

                    if (exists == true) {
                        $("#password").hide();
                        $("#password_2").hide();
                    }

                    if (tipo_pessoa == "Civil") {
                        $("#militar").hide();
                    }

                    $('#nome').val(nome).change();
                    $('#email').val(email).change();
                    $("#estado_civil").val(estado_civil).change();
                    $("#genero").val(genero).change();
                    $("#escolaridade").val(escolaridade).change();
                    $("#tipo_pessoa").val(tipo_pessoa).change();
                    $("#telefone").val(telefone).change();
                    $("#cep").val(cep).change();
                    $("#cidade_uf").val(cidade).change();
                    $("#endereco").val(endereco).change();
                    $("#bairro").val(bairro).change();
                    $("#complemento").val(complemento).change();
                    $("#forca").val(forca_id).change();
                    $("#qas_qms").val(qualificacoes_id).change();
                    $("#especialidade").val(especialidade).change();
                    $("#posto_graduacao").val(posto_graduacao_id).change();
                    $("#status_militar").val(status_militar_id).change();



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

    function mascara() {
        var cpf = document.getElementById('cpf_2');
        if (cpf.value.length == 3 || cpf.value.length == 7) {
            cpf.value += ".";
        } else if (cpf.value.length == 11) {
            cpf.value += "-";
        }

    }


    function exportarPdf() {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var nome = $("#nome").val();
        var cpf = $("#cpf").val();
        var email = $("#email").val();
        var tipo_pessoa = $("#tipo_pessoa").val();


        var dados = {

            "nome": nome,
            "cpf": cpf,
            "email": email,
            "tipo_pessoa": tipo_pessoa,
        };

        console.log(dados);

        Swal.fire({
            icon: 'info',
            title: 'Aguarde...',
            text: 'Aguarde o sistema está gerando o relatório em PDF'
        });

        $.ajax({
            url: "{{ route('participantes.pdf') }}",
            type: "POST",
            data: dados,
            headers: headers,
            xhrFields: {
                responseType: 'blob'
            },
            error: function(data) {

                Swal.fire({
                    icon: 'error',
                    title: 'Ops...',
                    text: 'Ocorreu um erro durante a geração do relatório, entre em contato com a DTI.'
                });
                console.log(data);

            },
            success: function(data) {

                var blob = new Blob([data], {
                    type: 'application/pdf'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "RelatórioParticipantes.pdf";
                link.click();

                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Relatório Gerado com sucesso.'
                });

            }
        });

    }

    function exportarExcel() {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var nome = $("#nome").val();
        var cpf = $("#cpf").val();
        var email = $("#email").val();
        var tipo_pessoa = $("#tipo_pessoa").val();


        var dados = {

            "nome": nome,
            "cpf": cpf,
            "email": email,
            "tipo_pessoa": tipo_pessoa,
        };


        Swal.fire({
            icon: 'info',
            title: 'Aguarde...',
            text: 'Aguarde o sistema está gerando o relatório em Excel'
        });

        $.ajax({
            url: "{{ route('participante.excel') }}",
            type: "POST",
            data: dados,
            headers: headers,
            xhrFields: {
                responseType: 'blob'
            },
            error: function(data) {

                Swal.fire({
                    icon: 'error',
                    title: 'Ops...',
                    text: 'Ocorreu um erro durante a geração do relatório, entre em contato com a DTI.'
                });

            },
            success: function(data) {
                //console.log(data);
                var blob = new Blob([data], {
                    type: 'application/vnd.ms-excel'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "RelatórioParticipantes.xlsx";
                link.click();

                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Relatório Gerado com sucesso.'
                });

            }
        });

    }
</script>