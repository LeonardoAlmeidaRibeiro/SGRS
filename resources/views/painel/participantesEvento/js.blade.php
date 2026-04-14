<script>

    function emitirCertificado(id){
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var inscricao_id = id;
        var certificado_evento = $("#qtd_certificado_evento").val();

        if(certificado_evento == 0){

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Certificado não configurado, configure o certificado antes da emissão'
            });
            return false;
        }
        $.ajax({
            url: "{{ route('emitirCertificado.store')}}",
            type: "POST",
            data: "&inscricao_id=" + inscricao_id,
            headers: headers,
            error:function(data){
                
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
            success: function(data){
                var message = '';
                var success = '';
                var id = '';

                $.each(data, function(campo, conteudo) {
                    
                    if (campo == 'success') {
                        success = conteudo;
                    }
                    if (campo == 'message') {
                        message = conteudo;
                    }if (campo == 'id') {
                        id = conteudo;
                    }

                    
                });
                
                if(success == true){
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: message
                    }).then(function() {
                        window.location.reload();
                    });
                }else{
                    Swal.fire({ icon: 'error', title: 'Oops...', text: message });
                }
                


            }
        })
    }
    
    function exportarPdf(tipo_certificado, inscricao_id){

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        
        var evento_id = $("#evento_id").val();
        var certificado = tipo_certificado;
        var inscricao_id = inscricao_id;

        
        var dados = {
            "evento_id":evento_id,
            "certificado":certificado,
            "inscricao_id":inscricao_id,

        }
        
        Swal.fire({ icon: 'info', title: 'Aguarde...', text: 'Aguarde o sistema está gerando o relatório em PDF'});
        
        $.ajax({
            url: "{{ route('certificadoPdf.export.pdf') }}",
            type: "POST",
            data: dados,
            headers: headers,
            xhrFields: {
                responseType: 'blob'
            },
            error: function(data) {
                
                Swal.fire({ icon: 'error', title: 'Ops...', text: 'Ocorreu um erro durante a geração do relatório, entre em contato com a DTI.' });  

            },
            success: function(data) {
                
                var blob = new Blob([data], { type: 'application/pdf' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "Certificado.pdf";
                link.click();

                Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Relatório Gerado com sucesso.' });  

            }
        });  

    }

    function excluirCertificado(id, evento_id, inscricao_id) {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var dados = {
            "evento_id": evento_id,
            "id_participante": id,
            "inscricao_id": inscricao_id
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
            if (result.value) {
                $.ajax({
                    url: "{{ route('excluirCertificado') }}",
                    type: "POST",
                    data: dados,
                    headers: headers,
                    success: function(data) {
                        var message = '';
                        var success = '';

                        $.each(data, function(campo, conteudo) {
                            if (campo == 'success') success = conteudo;
                            if (campo == 'message') message = conteudo;
                        });

                        if (success == true) {
                                Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: message
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
        });
    }



</script>