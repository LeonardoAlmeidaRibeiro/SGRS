<script>
   
    function mascara_cpf() {
        var cpf = document.getElementById('cpf');
        if (cpf.value.length == 3 || cpf.value.length == 7) {
            cpf.value += ".";
        } else if (cpf.value.length == 11) {
            cpf.value += "-";
        }
    }

    function mostrarCampos(){
        
        $("#forca_id").show();
        $("#qualificacao_id").show();
        $("#especialidade_id").show();
        $("#posto_id").show();
        $("#status_id").show();
    }

    function esconderCampos(){

        $("#forca_id").hide();
        $("#qualificacao_id").hide();
        $("#especialidade_id").hide();
        $("#posto_id").hide();
        $("#status_id").hide();

    }

    function inscrever(id){

            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }


            $("#enviarInscr").html('Aguarde...');
            $('#enviarInscr').prop('disabled', true); //Desabilita o botão

            $.ajax({
                url: "{{ route('evento.inscrever', '') }}/"+id,
                type: "POST",
                headers: headers,
                error: function(data) {
                    if(data.status === 422) {
                        var message = '';

                        $("#enviarInscr").html('Inscrição');
                        $('#enviarInscr').prop('disabled', false); //Habilita o botão novamente

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
                    var cpf = '';

                    $.each(data, function(campo, conteudo) {
                        if(campo == 'success'){
                            success = conteudo;
                        }
                        if(campo == 'message'){
                            message = conteudo;
                        }
                        if(campo == 'cpf'){
                            cpf = conteudo;
                        }
                    });

                    if(success == true){
                     
                        $("#enviarInscr").html('Inscrição');
                        $('#enviarInscr').prop('disabled', false); //Habilita o botão novamente

                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: message
                        }).then(function() {
                            window.location = "{{ route('inscricoes.Participante','') }}"+cpf;
                        });
                    }else{
                        $("#enviarInscr").html('Inscrição');
                        $('#enviarInscr').prop('disabled', false); //Habilita o botão novamente
                        
                        Swal.fire({ icon: 'error', title: 'Oops...', text: message });
                    }


                }
            });

    }

    function executarCriar() {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var nome = $("#nome").val();
        var cpf = $("#cpf").val();
        var cep = $("#cep").val();
        var cidade_uf = $("#cidade_uf").val();
        var endereco = $("#endereco").val();
        var complemento = $("#complemento").val();
        var email = $("#email").val();
        var senha = $("#senha").val();
        var senha_2 = $("#senha_2").val();
        var telefone = $("#telefone").val();
        var bairro = $("#bairro").val();
        var evento_id = $("#evento_id").val();
        var parametro = $("#parametro").val();
        var existe  = $("#existe").val();
        var categoria_profissional_id  = $("#categoria_profissional_id").val();
        
        var militar = [];
        $('input[type="radio"][name="militar"]:checked').each(function(){
            militar.push($(this).val()); 
        });
        var civil = [];
        $('input[type="radio"][name="civil"]:checked').each(function(){
            civil.push($(this).val()); 
        });
        var outro_militar = [];
        $('input[type="radio"][name="outro_militar"]:checked').each(function(){
            outro_militar.push($(this).val()); 
        });
        var outro_civil = [];
        $('input[type="radio"][name="outro_civil"]:checked').each(function(){
            outro_civil.push($(this).val()); 
        });

        var genero = [];
        $('input[type="radio"][name="genero"]:checked').each(function(){
            genero.push($(this).val()); 
        });

        var categoria_profissional_id = [];
        $('input[type="radio"][name="categoria_profissional_id"]:checked').each(function(){
            categoria_profissional_id.push($(this).val()); 
        });

        var estado_civil = [];
        $('input[type="radio"][name="estado_civil"]:checked').each(function(){
            estado_civil.push($(this).val()); 
        });

        var escolaridade = [];
        $('input[type="radio"][name="escolaridade"]:checked').each(function(){
            escolaridade.push($(this).val()); 
        });
    
        var forca = [];
        $('input[type="radio"][name="forca"]:checked').each(function(){
            forca.push($(this).val()); 
        });

        var qualificacao = [];
        $('input[type="radio"][name="qualificacao"]:checked').each(function(){
            qualificacao.push($(this).val()); 
        });

        var especialidade = [];
        $('input[type="radio"][name="especialidade"]:checked').each(function(){
            especialidade.push($(this).val()); 
        });
        
        var posto = [];
        $('input[type="radio"][name="posto"]:checked').each(function(){
            posto.push($(this).val()); 
        });

        var status = [];
        $('input[type="radio"][name="status"]:checked').each(function(){
            status.push($(this).val()); 
        });

        var tipo_pessoa = '';

        if(militar.length > 0){
            tipo_pessoa = 'Militar';
        }
        if(outro_militar.length > 0){
            tipo_pessoa = 'Outro Militar';
        }
        if(civil.length > 0){
            tipo_pessoa = 'Civil';
        }
        if(outro_civil.length > 0){
            tipo_pessoa = 'Outro Civil';
        }
        
        if (cpf == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo CPF'
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

        if (nome == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Nome'
            });
            return false;
        }

        if (militar.length == 0 && outro_militar.length == 0 && civil.length == 0 && outro_civil.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Tipo Pessoa!'
            });
            return false;
        }

        if (genero.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Genero!'
            });
            return false;
        }

        if (estado_civil.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Estado Civil!'
            });
            return false;
        }

        if (escolaridade.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo Escolaridade!'
            });
            return false;
        }

        if(militar.length > 0 || outro_militar.length > 0){
            if(civil.length == 0 && outro_civil.length == 0){

                if (forca.length == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Preencha o campo Força!'
                    });
                    return false;
                }

                if (qualificacao.length == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Preencha o campo Qualificação Militar!'
                    });
                    return false;
                }

                if (especialidade.length == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Preencha o campo Especialidade!'
                    });
                    return false;
                }

                if (posto.length == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Preencha o campo Posto Graduação!'
                    });
                    return false;
                }

                if (status.length == 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Preencha o campo Status Militar!'
                    });
                    return false;
                }
            }
        }
        

        if (cep == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Preencha o campo CEP'
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


        if(outro_civil.length > 0 || outro_militar.length > 0){

            if (senha == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Preencha o campo senha!'
                });
                return false;
            }

            if (senha_2 == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Você precisa confirmar a senha!'
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
        }

        // console.log(escolaridade[0]);

        if(civil.length > 0 || outro_civil.length > 0){

            var dados = {

                "nome": nome,
                "tipo_pessoa": tipo_pessoa,
                "cpf": cpf,
                "email": email,
                "telefone": telefone,
                "senha": senha,
                "endereco": endereco,
                "complemento": complemento,
                "bairro": bairro,
                "cidade_uf": cidade_uf,
                "cep": cep,
                "genero": genero[0],
                "estado_civil": estado_civil[0],
                "escolaridade": escolaridade[0],
                "qualificacao": null,
                "forca": null,
                "especialidade": null,
                "posto_graduacao": null,
                "status": null,
                "evento_id": evento_id,
                "parametro": parametro,
                "existe": existe,
                "categoria_profissional_id":categoria_profissional_id[0],

            }
        }else{
            var dados = {

                "nome": nome,
                "tipo_pessoa": tipo_pessoa,
                "cpf": cpf,
                "email": email,
                "telefone": telefone,
                "endereco": endereco,
                "senha": senha,
                "complemento": complemento,
                "bairro": bairro,
                "cidade_uf": cidade_uf,
                "cep": cep,
                "genero": genero[0],
                "estado_civil": estado_civil[0],
                "escolaridade": escolaridade[0],
                "qualificacao": qualificacao[0],
                "forca": forca[0],
                "especialidade": especialidade[0],
                "posto_graduacao": posto[0],
                "status": status[0],
                "evento_id": evento_id,
                "parametro": parametro,
                "existe":existe,        
                "categoria_profissional_id":categoria_profissional_id[0],                                                                                                                                          

            }
        }

        console.log(categoria_profissional_id);

        $("#enviarInscr").html('Aguarde...');
        $('#enviarInscr').prop('disabled', true); //Desabilita o botão
        

        $.ajax({
            url: "{{ route('cadastroParticipante.store.site') }}",
            type: "POST",
            data: dados,
            headers: headers,
            error: function(data) {
                //console.log(data);
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
                        window.location = "{{ route('login.Participante','') }}"+parametro;
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

   
        function editarNome(){

            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

            var id                        = $("#id").val();
            var nome                      = $("#nomeParticipante").val();
            var evento_id                 = $("#evento_id").val();
            var tipo_certificado          = $("#tipo_certificado").val();
            var participante_id           = $("#participante_id").val();
            var url                       = "{{ route('participante.imprimirCertificado') }}";

            console.log(id);
            console.log(evento_id);
            // console.log(window.location.host);
            
            if(nome == ''){
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Preencha o campo nome'});
                return false;
            }

            var dados = {
                "participante_id":participante_id,
                "nome":nome,
                "tipo_certificado":tipo_certificado,
                "evento_id":evento_id,
            }
     
            $.ajax({
                url: "{{ route('nomeParticipante.update', '') }}"+id,
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
                    console.log(data);
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

                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Nome Alterado com Sucesso!',
                        }).then(function() {
                            window.location = url + '?' + 'id='+evento_id+'&participante_id='+id;
                        });
                    }else{
                        Swal.fire({ icon: 'error', title: 'Oops...', text: message });
                    }
                    

                }
            });

}
    

</script>
