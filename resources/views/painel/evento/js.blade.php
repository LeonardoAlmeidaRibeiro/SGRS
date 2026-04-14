<script>

    let editor_desc;
        ClassicEditor
            .create( document.querySelector( '#evento' ), {
                toolbar: ['heading','|', 'bold', 'italic','bulletedList', 'numberedList', 'Alignment', 'fontFamily', 'fontSize','|', 'blockQuote', '|','undo', 'redo']
            } )
            .then( editor => {
                // console.log( Array.from( editor.ui.componentFactory.names() ));
                editor_desc = editor;
            } )
            .catch( error => {
                // console.log( error );
            } );
        function readOnly() {
            document.getElementById("dia").readOnly = false;
            document.getElementById("dia_edit").readOnly = false;
        }

    function executarModalCriar() {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        var imagemFile = $('#imagem')[0].files[0];
        var arqFile = $('#arq_programacao')[0].files[0];

        // Validação de imagem
        if (!imagemFile) {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Escolha uma imagem para o evento.' });
            return false;
        }

        var allowedImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedImageTypes.includes(imagemFile.type)) {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Formato de imagem inválido. Use JPG, PNG ou GIF.' });
            return false;
        }

        if (imagemFile.size > 10 * 1024 * 1024) {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'A imagem não pode ter mais de 10MB.' });
            return false;
        }

        // Validação de arquivo de programação
        if (arqFile) { // opcional, caso seja permitido enviar sem arquivo
            var allowedArqTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ];
            if (!allowedArqTypes.includes(arqFile.type)) {
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Formato de arquivo inválido. Use PDF ou DOC/DOCX.' });
                return false;
            }
            if (arqFile.size > 10 * 1024 * 1024) {
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'O arquivo não pode ter mais de 10MB.' });
                return false;
            }
        }
        
        var formData = new FormData();
        formData.append('imagem', $('#imagem')[0].files[0]);
        formData.append('arq_programacao', $('#arq_programacao')[0].files[0]);
        formData.append('nome_evento', $('#nome_evento').val());
        formData.append('email', $('#email').val());
        formData.append('data_evento', $('#data_evento').val());
        formData.append('unidade_evento_id', $('#unidade_evento_id').val());
        formData.append('unidade_evento_id_texto', $("#unidade_evento_id option:selected").text());
        formData.append('status_evento', $('#status_evento').val());
        formData.append('status_evento_texto', $("#status_evento option:selected").text());
        formData.append('categoria_evento_id', $('#categoria_evento_id').val());
        formData.append('categoria_evento_id_texto', $("#categoria_evento_id option:selected").text());
        formData.append('publico_alvo', $("select[name='publico_alvo[]']").map(function() {
            return $(this).val();
        }).get());
        formData.append('carga_horaria', $('#carga_horaria').val());
        formData.append('vaga_evento', $('#vaga_evento').val());
        formData.append('evento', editor_desc.getData());
        formData.append('video', $('#video').val());

        var imagemVal = $('#imagem').val();
        var nome_eventoVal = $("#nome_evento").val();
        var emailVal = $("#email").val();
        var carga_horariaVal = $("#carga_horaria").val();
        var vaga_eventoVal = $("#vaga_evento").val();
        var eventoVal = editor_desc.getData();
        var publico_alvoVal = $("#publico_alvo").val();
        var status_eventoVal = $("#status_evento").val();
        var unidade_evento_idVal = $("#unidade_evento_id").val();
        var categoria_evento_idVal = $("#categoria_evento_id").val();
        var data_eventoVal = $("#data_evento").val();

        if (nome_eventoVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo nome do evento não pode está vázio.'
            });
            return false;
        }
        if (emailVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo e-mail não pode está vázio..'
            });
            return false;
        }
        if (carga_horariaVal == '' || carga_horariaVal <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo carga horária não pode está vázio ou inferior a 0.'
            });
            return false;
        }
        if (vaga_eventoVal == '' || vaga_eventoVal <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo vagas do evento não pode está vázio ou inferior a 0.'
            });
            return false;
        }
        if (eventoVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo descrição do evento não pode está vázio.'
            });
            return false;
        }
        if (publico_alvoVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo público alvo não pode está vázio.'
            });
            return false;
        }
        if (status_eventoVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo status do evento não pode está vázio.'
            });
            return false;
        }
        if (unidade_evento_idVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo unidade do evento não pode está vázio.'
            });
            return false;
        }
        if (categoria_evento_idVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo categoria do evento não pode está vázio.'
            });
            return false;
        }
        if (data_eventoVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo data do evento não pode está vázio.'
            });
            return false;
        }

        if (imagemVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Escolha uma imagem para o evento.'
            });
            return false;
        }

        $("#criar").html('Aguarde...');
        $('#criar').prop('disabled', true); //Desabilita o botão

        $.ajax({
            url: "{{ route('eventos.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: headers,
            error: function(data) {

                if (data.status === 422) {

                    $("#criar").html('Salvar');
                    $('#criar').prop('disabled', false); //Habilita o botão novamente

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

                $('#modal_cadastro').modal('toggle');

                var message = '';
                var success = '';
                var id = '';

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
                });

                if (success == true) {

                    $("#criar").html('Enviar');
                    $('#criar').prop('disabled', false); //Habilita o botão novamente

                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'O Evento aberto com sucesso, nº' + id,
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then(function() {
                        window.location = "{{ route('eventos.index') }}";
                    });

                } else {


                    $("#criar").html('Enviar');
                    $('#criar').prop('disabled', false); //Habilita o botão novamente

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: message
                    });
                }
            }
        });

    }
        
    function atualizarEvento(id) {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        
        var formData = new FormData();
        formData.append('imagem', $('#imagem')[0].files[0]);
        formData.append('arq_programacao', $('#arq_programacao')[0].files[0]);
        formData.append('nome_evento', $('#nome_evento').val());
        formData.append('email', $('#email').val());
        formData.append('data_evento', $('#data_evento').val());
        formData.append('unidade_evento_id', $('#unidade_evento_id').val());
        formData.append('unidade_evento_id_texto', $("#unidade_evento_id option:selected").text());
        formData.append('status_evento', $('#status_evento').val());
        formData.append('status_evento_texto', $("#status_evento option:selected").text());
        formData.append('categoria_evento_id', $('#categoria_evento_id').val());
        formData.append('categoria_evento_id_texto', $("#categoria_evento_id option:selected").text());
        formData.append('publico_alvo', $("select[name='publico_alvo[]']").map(function() {
            return $(this).val();
        }).get());
        formData.append('carga_horaria', $('#carga_horaria').val());
        formData.append('vaga_evento', $('#vaga_evento').val());
        formData.append('evento_edit', editor_desc.getData());
        formData.append('video', $('#video').val());

        var imagemVal = $('#imagem').val();
        var nome_eventoVal = $("#nome_evento").val();
        var emailVal = $("#email").val();
        var carga_horariaVal = $("#carga_horaria").val();
        var vaga_eventoVal = $("#vaga_evento").val();
        var eventoVal = editor_desc.getData();
        var publico_alvoVal = $("select[name='publico_alvo[]']").val();
        var status_eventoVal = $("#status_evento").val();
        var unidade_evento_idVal = $("#unidade_evento_id").val();
        var categoria_evento_idVal = $("#categoria_evento_id").val();
        var data_eventoVal = $("#data_evento").val();

        if (nome_eventoVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo nome do evento não pode está vázio.'
            });
            return false;
        }
        if (emailVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo e-mail não pode está vázio.'
            });
            return false;
        }
        if (carga_horariaVal == '' || carga_horariaVal <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo carga horária não pode está vázio ou ser inferior a 0.'
            });
            return false;
        }
        if (vaga_eventoVal == '' || vaga_eventoVal <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo vagas do evento não pode está vázio ou ser inferior a 0.'
            });
            return false;
        }
        if (eventoVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo descrição do evento não pode está vázio.'
            });
            return false;
        }
        if (publico_alvoVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo público alvo não pode está vázio.'
            });
            return false;
        }
        if (status_eventoVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo status do evento não pode está vázio.'
            });
            return false;
        }
        if (unidade_evento_idVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo unidade do evento não pode está vázio.'
            });
            return false;
        }
        if (categoria_evento_idVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo categoria do evento não pode está vázio.'
            });
            return false;
        }
        if (data_eventoVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo data do evento não pode está vázio.'
            });
            return false;
        }

        $("#criar").html('Aguarde...');
        $('#criar').prop('disabled', true); //Desabilita o botão


        $.ajax({
            url: "{{ route('eventos.atualizar', '') }}/" + id,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: headers,
            error: function(data) {

                if (data.status === 422) {
                    $("#criar").html('Atualizar');
                    $('#criar').prop('disabled', false); //Habilita o botão novamente

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

                $('#modal_cadastro').modal('toggle');

                var message = '';
                var success = '';
                var id = '';

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
                });

                if (success == true) {

                    $("#criar").html('Atualizar');
                    $('#criar').prop('disabled', false); //Habilita o botão novamente

                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'O  Atualizado com sucesso.',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then(function() {
                        window.location = "{{ route('eventos.index') }}";
                    });

                } else {

                    $("#criar").html('Atualizar');
                    $('#criar').prop('disabled', false); //Habilita o botão novamente

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: message
                    });
                }
            }
        });

    }

    function exportarPdf() {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var evento = $("#nome_evento").val();
        var categoria = $("#categoria_evento").val();
        var situacao = $("#situacao_evento").val();
        var unidade = $("#local_evento").val();


        var dados = {

            "nome_evento": evento,
            "categoria_evento_id": categoria,
            "status_evento": situacao,
            "unidade_evento_id": unidade,
        };

        Swal.fire({
            icon: 'info',
            title: 'Aguarde...',
            text: 'Aguarde o sistema está gerando o relatório em PDF'
        });

        $.ajax({
            url: "{{ route('eventos.pdf') }}",
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

                var blob = new Blob([data], {
                    type: 'application/pdf'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "RelatórioEventos.pdf";
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

        var evento = $("#nome_evento").val();
        var categoria = $("#categoria_evento").val();
        var situacao = $("#situacao_evento").val();
        var unidade = $("#local_evento").val();


        var dados = {

            "nome_evento": evento,
            "categoria_evento_id": categoria,
            "status_evento": situacao,
            "unidade_evento_id": unidade,
        };


        Swal.fire({
            icon: 'info',
            title: 'Aguarde...',
            text: 'Aguarde o sistema está gerando o relatório em Excel'
        });

        $.ajax({
            url: "{{ route('eventos.excel') }}",
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
                var blob = new Blob([data], {
                    type: 'application/vnd.ms-excel'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "RelatórioEventos.xlsx";
                link.click();

                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Relatório Gerado com sucesso.'
                });

            }
        });

    }

    function executarCriarDia() {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var dia = $("#dia").val();
        var evento_id = $("#evento_id").val();
        var data_evento = $("#data_evento").val();


        if (dia == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo Dia não pode está vázio.',
                time: 5000,
            });
            return false;
        }

        if (dia < data_evento) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'A data do evento não pode ser anterior à data definida.',
                time: 5000,
            });
            return false;
        }


        var dados = {

            "dia": dia,
            "evento_id": evento_id
        };

        $("#criar").html('Aguarde...');
        $('#criar').prop('disabled', true); //Desabilita o botão

        $.ajax({
            url: "{{ route('eventos.storeProgramacao') }}",
            type: "POST",
            data: dados,
            headers: headers,
            error: function(data) {
                if (data.status === 422) {

                    $("#criar").html('Adicionar');
                    $('#criar').prop('disabled', false); //Habilita o botão novamente

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

                $('#modal_cadastro').modal('toggle');

                var message = '';
                var success = '';
                var id = '';

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
                });

                if (success == true) {

                    $("#criar").html('Adicionar');
                    $('#criar').prop('disabled', false); //Habilita o botão novamente

                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Dia adicionado com sucesso!',
                        allowOutsideClick: false,
                        time: 5000
                    }).then(function() {
                        window.location.reload();
                    })

                } else {

                    $("#criar").html('Adicionar');
                    $('#criar').prop('disabled', false); //Habilita o botão novamente

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: message
                    });
                }


            }
        });

    }

    function excluir(id) {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        Swal.fire({
            title: 'Tem certeza que deseja excluir?',
            text: "Não será possível reverter essa ação.",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir!'
        }).then((result) => {

            if (typeof(result.value) != "undefined" && result.value == true) { // Se foi apertado o botão de "Sim, excluir"

                $.ajax({
                    url: "{{ route('eventos.destroyProgramacao', '') }}/" + id,
                    type: "DELETE",
                    headers: headers,
                    success: function(data) {

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
                            $('#tr_' + id).remove();
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

        })

    }

    function abrirModalEditar(id) {

        var celula_a = $("#celula_a_" + id).text();

        $("#id_edit").val(id);
        $("#dia_edit").val(celula_a);

        var dia = $("#data_dia_" + id).val();
        $("#dia_edit").val(dia);
        var data = $("#data_dia_" + id).val();
        $("#dia_edit").val(dia);

    }

    function executarModalEditar() {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var id = $("#id_edit").val();
        var dia = $("#dia_edit").val();
        var data = $("#data_evento").val();
        var dia_texto = dia.split('-').reverse().join('/');

        console.log(data)

        if (dia == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o Dia'
            });
            return false;
        }

        if (dia < data) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'A data do evento não pode ser anterior à data definida.'
            });
            return false;
        }

        var dados = {

            "dia": dia
        };


        $.ajax({
            url: "{{ route('eventos.updateProgramacao', '') }}/" + id,
            type: "PUT",
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

                $('#modal_editar').modal('toggle');

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
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: message
                    });
                    window.location.reload();
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

    function executarCriaHora() {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var hora = $("#hora").val();
        var evento_prog_dia_id = $("#evento_prog_dia_id").val();
        var conteudo = $("#conteudo").val();

        if (hora == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo Hora não pode está vázio.'
            });
            return false;
        }

        if (conteudo == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo conteúdo não pode está vázio.'
            });
            return false;
        }
        var dados = {

            "hora": hora,
            "evento_prog_dia_id": evento_prog_dia_id,
            "conteudo": conteudo
        };

        $("#criar").html('Aguarde...');
        $('#criar').prop('disabled', true); //Desabilita o botão

        $.ajax({
            url: "{{ route('eventos.storeConteudo') }}",
            type: "POST",
            data: dados,
            headers: headers,
            error: function(data) {
                if (data.status === 422) {

                    $("#criar").html('Adicionar');
                    $('#criar').prop('disabled', false); //Habilita o botão novamente

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

                $('#modal_cadastro').modal('toggle');

                var message = '';
                var success = '';
                var id = '';

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
                });

                if (success == true) {

                    $("#criar").html('Adicionar');
                    $('#criar').prop('disabled', false); //Habilita o botão novamente

                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Conteúdo do evento adicionado com sucesso',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then(function() {
                        window.location.reload();
                    });
                } else {

                    $("#criar").html('Adicionar');
                    $('#criar').prop('disabled', false); //Habilita o botão novamente

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: message
                    });
                }


            }
        });

    }

    function abrirModalEditarHora(id) {

        var celula_a = $("#celula_a_" + id).text();
        var celula_b = $("#celula_b_" + id).text();

        $("#id_edit").val(id);
        $("#hora_edit").val(celula_a);
        $("#conteudo_edit").val(celula_b);
    }

    function executarModalEditarHora() {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var id = $("#id_edit").val();
        var hora = $("#hora_edit").val();
        var conteudo = $("#conteudo_edit").val();

        if (hora == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o Dia'
            });
            return false;
        }

        if (conteudo == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o Dia'
            });
            return false;
        }



        var dados = {

            "hora": hora,
            "conteudo": conteudo
        };


        $.ajax({
            url: "{{ route('eventos.updateConteudo', '') }}/" + id,
            type: "PUT",
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

                $('#modal_editar').modal('toggle');

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
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: message
                    });
                    window.location.reload();
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

    function excluirHora(id) {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        Swal.fire({
            title: 'Tem certeza que deseja excluir?',
            text: "Não será possível reverter essa ação.",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir!'
        }).then((result) => {

            if (typeof(result.value) != "undefined" && result.value == true) { // Se foi apertado o botão de "Sim, excluir"

                $.ajax({
                    url: "{{ route('eventos.destroyConteudo', '') }}/" + id,
                    type: "DELETE",
                    headers: headers,
                    success: function(data) {

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
                            $('#tr_' + id).remove();
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

        })

    }

    function executarSalvarDocumento() {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var formData = new FormData();
        formData.append('nome_documento', $('#nome_documento').val());
        formData.append('arquivo_documento', $('#arquivo_documento')[0].files[0]);
        formData.append('evento_id', $('#evento_id').val());


        var arquivo_documentoVal = $('#arquivo_documento').val();
        var nome_documentoVal = $("#nome_documento").val();

        if (nome_documentoVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo nome do documento não pode está vázio.'
            });
            return false;
        }
        if (arquivo_documentoVal == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo Arquivo não pode está vázio.'
            });
            return false;
        }

        $("#criar").html('Aguarde...');
        $('#criar').prop('disabled', true); //Desabilita o botão

        $.ajax({
            url: "{{ route('eventos.storeDocumentoEvento') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: headers,
            error: function(data) {

                if (data.status === 422) {

                    $("#criar").html('Adicionar');
                    $('#criar').prop('disabled', false); //Habilita o botão novamente

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

                $('#modal_cadastro').modal('toggle');

                var message = '';
                var success = '';
                var id = '';

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
                });

                if (success == true) {

                    $("#criar").html('Adicionar');
                    $('#criar').prop('disabled', false); //Habilita o botão novamente

                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'O Documento adicionado com sucesso ao evento.',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then(function() {
                        window.location.reload();
                    });

                } else {

                    $("#criar").html('Adicionar');
                    $('#criar').prop('disabled', false); //Habilita o botão novamente

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: message
                    });
                }
            }
        });

    }

    function excluirDocumentoEvento(id) {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        Swal.fire({
            title: 'Tem certeza que deseja excluir?',
            text: "Não será possível reverter essa ação.",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir!'
        }).then((result) => {

            if (typeof(result.value) != "undefined" && result.value == true) { // Se foi apertado o botão de "Sim, excluir"

                $.ajax({
                    url: "{{ route('eventos.destroyDocumento', '') }}/" + id,
                    type: "DELETE",
                    headers: headers,
                    success: function(data) {

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
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: 'O Documento removido com sucesso ao evento.',
                                showConfirmButton: true,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            }).then(function() {
                                window.location.reload();
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

        })

    }

    function cadastrarParticipanteEvento() {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }



        var evento_id = $("#evento_id").val();
        var participante_id = $("#participante_id").val();
        var participante = $("#participante").val();
        var palestrante = $("#palestrante").val();
        var org_evento = $("#org_evento").val();
        var ouvinte = $("#ouvinte").val();
        var forma_inscricao_id = $("#forma_inscricao_id").val();
        var conhecimento_evento_id = $("#conhecimento_evento_id").val();


        if (participante_id == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo Nome não pode está vázio.'
            });
            return false;
        }
        if (conhecimento_evento_id == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo Forma de Conhecimento do evento não pode está vázio.'
            });
            return false;
        }
        if (forma_inscricao_id == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo Forma de Inscrição não pode está vázio.'
            });
            return false;
        }
        if (participante == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo Participante não pode está vázio.'
            });
            return false;
        }
        if (palestrante == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo Participante não pode está vázio.'
            });
            return false;
        }
        if (org_evento == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo Organizador do Evento não pode está vázio.'
            });
            return false;
        }
        if (ouvinte == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'O campo Ouvinte não pode está vázio.'
            });
            return false;
        }

        var dados = {

            "evento_id": evento_id,
            "participante_id": participante_id,
            "participante": participante,
            "palestrante": palestrante,
            "org_evento": org_evento,
            "ouvinte": ouvinte,
            "forma_inscricao_id": forma_inscricao_id,
            "conhecimento_evento_id": conhecimento_evento_id

        };

        $.ajax({
            url: "{{ route('eventos.storeParticipanteEvento') }}",
            type: "POST",
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

                $('#modal_cadastro').modal('toggle');

                var message = '';
                var success = '';
                var id = '';

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
                });

                if (success == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Participante adicionado com sucesso',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then(function() {
                        window.location.reload();
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

    function excluirParticipanteEvento(id) {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        Swal.fire({
            title: 'Tem certeza que deseja excluir?',
            text: "Não será possível reverter essa ação.",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir!'
        }).then((result) => {

            if (typeof(result.value) != "undefined" && result.value == true) { // Se foi apertado o botão de "Sim, excluir"

                $.ajax({
                    url: "{{ route('eventos.destroyParticipanteEvento', '') }}/" + id,
                    type: "DELETE",
                    headers: headers,
                    success: function(data) {

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
                            $('#tr_' + id).remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: 'Participate removido com sucesso ao evento.'
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

        })

    }

    function exportarPdfInscristos() {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var participante_id = $("#participante_id").val();
        var evento_id = $("#evento_id").val();
        var participante = $("#participante").val();
        var palestrante = $("#palestrante").val();
        var ouvinte = $("#ouvinte").val();
        var org_evento = $("#org_evento").val();


        var dados = {

            "participante_id": participante_id,
            "evento_id": evento_id,
            "participante": participante,
            "palestrante": palestrante,
            "ouvinte": ouvinte,
            "org_evento": org_evento,

        };

        Swal.fire({
            icon: 'info',
            title: 'Aguarde...',
            text: 'Aguarde o sistema está gerando o relatório em PDF'
        });

        $.ajax({
            url: "{{ route('eventos.exportpdfInscritoEvento') }}",
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

                var blob = new Blob([data], {
                    type: 'application/pdf'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "EventosListaParticipantes.pdf";
                link.click();

                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Relatório Gerado com sucesso.'
                });

            }
        });

    }

    function exportarExcelInscristos() {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var participante_id = $("#participante_id").val();
        var evento_id = $("#evento_id").val();
        var participante = $("#participante").val();
        var palestrante = $("#palestrante").val();
        var ouvinte = $("#ouvinte").val();
        var org_evento = $("#org_evento").val();


        var dados = {

            "participante_id": participante_id,
            "evento_id": evento_id,
            "participante": participante,
            "palestrante": palestrante,
            "ouvinte": ouvinte,
            "org_evento": org_evento,

        };

        Swal.fire({
            icon: 'info',
            title: 'Aguarde...',
            text: 'Aguarde o sistema está gerando o relatório em Excel'
        });

        $.ajax({
            url: "{{ route('eventos.exportexcelInscritoEvento') }}",
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
                var blob = new Blob([data], {
                    type: 'application/vnd.ms-excel'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "EventosListaParticipantes.xlsx";
                link.click();

                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Relatório Gerado com sucesso.'
                });

            }
        });

    }

    function exportarPdfInscristosDadosPessoais(id) {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var participante_id = $("#participante_id").val();
        var evento_id = $("#evento_id").val();
        var participante = $("#participante").val();
        var palestrante = $("#palestrante").val();
        var ouvinte = $("#ouvinte").val();
        var org_evento = $("#org_evento").val();
        var evento = $("#org_evento").val();

        var dados = {

            "participante_id": participante_id,
            "evento_id": evento_id,
            "participante": participante,
            "palestrante": palestrante,
            "ouvinte": ouvinte,
            "org_evento": org_evento,

        };

        Swal.fire({
            icon: 'info',
            title: 'Aguarde...',
            text: 'Aguarde o sistema está gerando o relatório em PDF'
        });

        $.ajax({
            url: "{{ route('eventos.inscricaoDadosPessoaisPdf', '') }}/" + id,
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

                var blob = new Blob([data], {
                    type: 'application/pdf'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "RelacaoDadosPessoais.pdf";
                link.click();

                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Relatório Gerado com sucesso.'
                });

            }
        });

    }

    function exportarExcelInscristosDadosPessoais(id) {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        Swal.fire({
            icon: 'info',
            title: 'Aguarde...',
            text: 'Aguarde o sistema está gerando o relatório em Excel'
        });

        $.ajax({
            url: "{{ route('eventos.exportExcelInscritoDadosPessoais', '') }}/" + id,
            type: "POST",
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
                var blob = new Blob([data], {
                    type: 'application/vnd.ms-excel'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "RelacaoDadosPessoais.xlsx";
                link.click();

                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Relatório Gerado com sucesso.'
                });

            }
        });

    }

    function abrirModalEditarParticipante(id) {

        var celula_b = $("#celula_b_" + id).text();
        var celula_c = $("#celula_c_" + id).text();
        var celula_d = $("#celula_d_" + id).text();
        var celula_e = $("#celula_e_" + id).text();
        var celula_f = $("#celula_f_" + id).text();
        var celula_g = $("#celula_g_" + id).text();

        $("#id_edit").val(id);

        var forma_conhecimento = $("#conhecimento_evento_nome_valor_" + id).val();
        $("#conhecimento_evento_edit").val(forma_conhecimento);
        var forma_inscricao = $("#forma_inscricao_nome_valor_" + id).val();
        $("#forma_inscricao_edit").val(forma_inscricao);
        var participante = $("#participante_valor_" + id).val();
        $("#participante_edit").val(participante);
        var palestrante = $("#palestrante_valor_" + id).val();
        $("#palestrante_edit").val(palestrante);
        var organizador = $("#organizador_valor_" + id).val();
        $("#organizador_edit").val(organizador);
        var ouvinte = $("#ouvinte_valor_" + id).val();
        $("#ouvinte_edit").val(ouvinte);

        console.log(forma_conhecimento);
        console.log(forma_inscricao);

    }

    function executarModalEditarParticipante() {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var id = $("#id_edit").val();
        var forma_conhecimento = $("#conhecimento_evento_edit").val();
        var forma_conhecimento_texto = $("#conhecimento_evento_edit option:selected").text();
        var forma_inscricao = $("#forma_inscricao_edit").val();
        var forma_inscricao_texto = $("#forma_inscricao_edit option:selected").text();
        var participante = $("#participante_edit").val();
        var palestrante = $("#palestrante_edit").val();
        var org_evento = $("#organizador_edit").val();
        var ouvinte = $("#ouvinte_edit").val();

        if (forma_conhecimento == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o Campo Conhecimento do Evento.'
            });
            return false;
        }

        if (forma_inscricao == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o Campo Forma de Conhecimento.'
            });
            return false;
        }

        if (participante == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o Campo Participante.'
            });
            return false;
        }

        if (palestrante == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o Campo Palestrante.'
            });
            return false;
        }

        if (org_evento == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o Campo Organizador.'
            });
            return false;
        }

        if (ouvinte == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o Campo Ouvinte.'
            });
            return false;
        }

        var dados = {
            "forma_conhecimento": forma_conhecimento,
            "forma_inscricao": forma_inscricao,
            "participante": participante,
            "palestrante": palestrante,
            "org_evento": org_evento,
            "ouvinte": ouvinte,

        };

        console.log(dados)

        $.ajax({
            url: "{{ route('eventos.updateParticipanteEvento', '') }}/" + id,
            type: "PUT",
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
                $('#modal_editar_participante_evento').modal('toggle');

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
                    $("#celula_b_" + id).html(forma_conhecimento_texto);
                    $("#celula_c_" + id).html(forma_inscricao_texto);
                    $("#celula_d_" + id).html(participante == 'S' ? 'Sim' : 'Não');
                    $("#celula_e_" + id).html(palestrante == 'S' ? 'Sim' : 'Não');
                    $("#celula_f_" + id).html(org_evento == 'S' ? 'Sim' : 'Não');
                    $("#celula_g_" + id).html(ouvinte == 'S' ? 'Sim' : 'Não');
                    $("#conhecimento_evento_nome_valor_" + id).val(forma_conhecimento);
                    $("#forma_inscricao_nome_valor_" + id).val(forma_inscricao);
                    $("#participante_valor_" + id).val(participante);
                    $("#palestrante_valor_" + id).val(palestrante);
                    $("#organizador_valor_" + id).val(org_evento);
                    $("#ouvinte_valor_" + id).val(ouvinte);

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