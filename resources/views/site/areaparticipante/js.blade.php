<script>
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
</script>