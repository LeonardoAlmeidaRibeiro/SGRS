<script>
    $("#tabela").DataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
        },
        "dom": "<'row'" +
            "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +

            "<'table-responsive'tr>" +

            "<'row'" +
            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
    });

    function abrirModalEditar(id) {

        var celula_a = $("#celula_a_" + id).text();

        $("#id_edit").val(id);
        $("#nome_edit").val(celula_a);

    }

    function executarModalEditar() {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var id = $("#id_edit").val();
        var nome = $("#nome_edit").val();
        
        if (nome == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Forma de Inscrição'
            });
            return false;
        }

        $.ajax({
            url: "{{ route('inscricaoEvento.update', '') }}/" + id,
            type: "PUT",
            data: "&nome=" + nome,
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
                    $("#celula_a_" + id).html(nome);
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

    function executarModalCriar() {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var nome = $("#nome").val();

        if (nome == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Forma de Inscrição'
            });
            return false;
        }

        $.ajax({
            url: "{{ route('inscricaoEvento.store') }}",
            type: "POST",
            data: "&nome=" + nome,
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

                    $("#nome").val("");

                    var novoRegistro = '<tr id="tr_' + id + '">' +
                        '<td>' +
                        '    <a href="#" onClick="return abrirModalEditar(' + id + ');" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6" data-bs-toggle="modal" data-bs-target="#modal_editar"><div id="celula_a_' + id + '">' + nome + '</div></a>' +
                        '</td>' +
                        '<td class="text-end">' +
                        '    <div class="card-toolbar">' +
                        '        <a href="#" class="btn btn-sm btn-light-primary" onClick="return abrirModalEditar(' + id + ');" data-bs-toggle="modal" data-bs-target="#modal_editar">' +
                        '            <span class="svg-icon svg-icon-2">' +
                        '                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">' +
                        '                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />' +
                        '                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />' +
                        '                </svg>' +
                        '            </span>' +
                        '        Editar	</a>' +
                        '        <button type="button" class="btn btn-sm btn-light-danger" onClick="return excluir(' + id + ');">' +
                        '            <span class="svg-icon svg-icon-2">' +
                        '                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">' +
                        '                    <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />' +
                        '                    <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />' +
                        '                    <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />' +
                        '                </svg>' +
                        '            </span>' +
                        '        Excluir</button>' +
                        '    </div>' +
                        '</td>' +
                        '</tr>';

                    $("#tabela").prepend(novoRegistro);

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
                    url: "{{ route('inscricaoEvento.destroy', '') }}/" + id,
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
</script>