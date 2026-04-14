<script>
    
    $("#tabela").DataTable({
        "language": {
        "lengthMenu": "Mostrar _MENU_ registros",
    },
    "dom":
    "<'row'" +
    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
    ">" +

    "<'table-responsive'tr>" +

    "<'row'" +
    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
    ">"
    });

    function abrirModalEditar(id){

        var celula_a = $("#celula_a_"+id).text().trim();
        var celula_c = $("#perfil_id_"+id).val();

        $("#id_edit").val(id);
        $("#name_edit").val(celula_a);
        $("#perfil_edit").val(celula_c).change();

    }

    function executarModalEditar(){

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var id            = $("#id_edit").val();
        var name          = $("#name_edit").val();
        var perfil        = $("#perfil_edit").val();
        var perfil_texto  = $("#perfil_edit option:selected").text();

        dados = {
            "nome":name,
            "perfil":perfil,
        };
     
        $.ajax({
            url: "{{ route('usuario.update', '') }}/"+id,
            type: "PUT",
            data: dados,
            headers: headers,
            error: function(data) {
                
                if(data.status === 422) {
                    var message = '';
                    $.each(data.responseJSON.errors, function(campo, conteudo) {
                        message = message.concat(conteudo);
                    });
                    Swal.fire({ icon: 'error', title: 'Oops...', text: message });
                }

            },
            success: function(data) {
                
                $('#modal_editar').modal('toggle');

                var message = '';
                var success = '';
                
                $.each(data, function(campo, conteudo) {
                    if(campo == 'success'){
                        success = conteudo;
                    }
                    if(campo == 'message'){
                        message = conteudo;
                    }
                });

                if(success == true){
                    $("#celula_a_"+id).html(name);
                    $("#celula_c_"+id).html(perfil_texto);
                    $("#perfil_id_"+id).val(perfil);

                    Swal.fire({ icon: 'success', title: 'Sucesso!', text: message });
                }else{
                    Swal.fire({ icon: 'error', title: 'Oops...', text: message });
                }
                

            }
        });

    }

   
</script>