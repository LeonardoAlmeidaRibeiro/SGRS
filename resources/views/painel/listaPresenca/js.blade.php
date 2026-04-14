<script>
    function listaPresenca(id) {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var presenca = document.querySelector('#presenca_' + id);

        if (presenca.checked == true) {
            presenca = 'S';
        }
        if (presenca.checked == false) {
            presenca = 'N';
        }

        var dados = {
            "presenca": presenca,
        }

        $.ajax({
            url: "{{route('listaPresenca.update', '') }}/" + id,
            type: 'post',
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

                if (success == false) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: message
                    });
                }


            }
        });
    }

    function listageral(id) {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        Swal.fire({
            title: 'Tem certeza que deseja marcar todos os participantes como presente?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, Confirmar Presença!'
        }).then((result) => {

            if (typeof(result.value) != "undefined" && result.value == true) { // Se foi apertado o botão de 'Sim, Confirmar Presença!'

                $.ajax({
                    url: "{{ route('todosPresentes.update', '') }}/" + id,
                    type: "post",
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
                                text: message
                            }).then(function() {
                                window.location = "{{ route('listaPresenca.index', '') }}/" + id;
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

    function exportarPdf(id) {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        Swal.fire({
            icon: 'info',
            title: 'Aguarde...',
            text: 'Aguarde o sistema está gerando o relatório em PDF'
        });

        $.ajax({
            url: "{{ route('listaPresenca.pdf', '') }}/" + id,
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
                console.log(data);

            },
            success: function(data) {

                var blob = new Blob([data], {
                    type: 'application/pdf'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "ParticipantesListaPresenca.pdf";
                link.click();

                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Relatório Gerado com sucesso.'
                });

            }
        });

    }

    function exportarExcel(id) {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        Swal.fire({
            icon: 'info',
            title: 'Aguarde...',
            text: 'Aguarde o sistema está gerando o relatório em Excel'
        });

        $.ajax({
            url: "{{ route('listaPresenca.excel', '') }}/" + id,
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
                link.download = "ParticipantesListaPresenca.xlsx";
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