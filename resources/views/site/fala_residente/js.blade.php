<script type="text/javascript">

	function executarModalCriar() {

		var headers = {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
		var nome = $("#nome").val();
		var email = $("#email").val();
		var documento = $("#documento").val();
		var clinica = $("#clinica").val();
		var mensagem = $("#mensagem").val();

		var anonimo = [];
        $('input[type="radio"][name="Anonimo"]:checked').each(function(){
            anonimo.push($(this).val()); 
        });
        var identificado = [];
        $('input[type="radio"][name="Identificado"]:checked').each(function(){
            identificado.push($(this).val()); 
        });

		var tipo_formulario = '';

        if(anonimo.length > 0){
            tipo_formulario = 'Anonimo';
        }
        if(identificado.length > 0){
            tipo_formulario = 'Identificado';
        }
		
		if(tipo_formulario != ''){
			if(tipo_formulario == 'Identificado'){

					if(nome == ''){
						Swal.fire({ icon: 'error', title: 'Oops...', text: 'Preencha o campo Nome'});
						return false;
					}
					if(email == ''){
						Swal.fire({ icon: 'error', title: 'Oops...', text: 'Preencha o campo Email'});
						return false;
					}
				
					if(clinica == ''){
						Swal.fire({ icon: 'error', title: 'Oops...', text: 'Preencha o campo Clinica'});
						return false;
					}
					if(mensagem.trim() == ''){
						Swal.fire({ icon: 'error', title: 'Oops...', text: 'Você precisa enviar uma mensagem!'});
						return false;
					}
			}else{
				if(mensagem.trim() == ''){
						Swal.fire({ icon: 'error', title: 'Oops...', text: 'Você precisa enviar uma mensagem!'});
						return false;
					}
			}
		}else{
			Swal.fire({ icon: 'error', title: 'Oops...', text: 'Preencha o Tipo de Formulário!'});
					return false;
		}
	
		// console.log(nome_perm);

		var dados = {
			"tipo_formulario": tipo_formulario,
			"nome": nome,
			'email': email,
			'clinica': clinica,
			'documento': documento,
			'mensagem': mensagem,
			"g_recaptcha_response": grecaptcha.getResponse()
		};

		console.log(dados);
		// return false;

		$.ajax({
			url: "{{ route('falaResidente.store') }}",
			type: "POST",
			data: dados,
			headers: headers,
			error: function(data) {
				console.log(data);
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
						text: 'Mensagem enviada com sucesso!'
					}).then(function() {
						window.location = "{{ route('falaResidente.index') }}";
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

	function enviarMensagem() {

		var headers = {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}

		var user_id = $("#user_id").val();
		var para = $("#para").val();
		var mensagem = $("#mensagem_resposta").val();


		var dados = {
			"user_id": user_id,
			"para": para,
			'mensagem': mensagem,
		};

		console.log(dados);
		// return false;

		$.ajax({
			url: "{{ route('painel.falaResidente.responder') }}",
			type: "POST",
			data: dados,
			headers: headers,
			error: function(data) {
				console.log(data);
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
						text: 'Resposta enviada com sucesso!'
					}).then(function() {
						window.location = "{{ route('painel.falaResidente.index') }}";
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

	function enviarEmail(id) {

		var headers = {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}

		var fala_residente_id = $("#fala_residente_id").val();
		var para = $("#para").val();
		var mensagem = $("#mensagem_resposta").val();


		var dados = {
			"fala_residente_id": fala_residente_id,
			"para": para,
			'mensagem': mensagem,
		};

		console.log(dados);
		// return false;

		$.ajax({
			url: "{{ route('painel.falaResidente.email') }}",
			type: "GET",
			data: dados,
			headers: headers,
			error: function(data) {
				console.log(data);
				if (data.status === 422 && data.status === 500) {
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
						text: 'Resposta enviada com sucesso!'
					}).then(function() {
						window.location = "{{ route('painel.falaResidente.index') }}";
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

	function abrirModalResposta(id){

		var nome 			= $("#celula_a_"+id).text();
		var respondido_em 	= $("#celula_b_"+id).text();
		var respondido 		= respondido_em.trim();

		var fala_residente 	= $("#fala_residente_"+id).val();
		var resposta 		= $("#resposta_tr_"+id).val();

		if(respondido != ''){
			
			$("#respondido").html(resposta);
			$("#mensagem_resposta").hide();
			$("#salvarResposta").hide();
		
		}else{

			$("#respondido").html('');
			$("#mensagem_resposta").show();
			$("#mensagem_resposta").val(resposta);
			$("#salvarResposta").show();

		}

		$("#para").val(nome);
		$("#fala_residente_id").val(fala_residente);

	}

	function naoPodeResponder(){
		Swal.fire({
			icon: 'error',
			title: 'Oops...',
			text: 'Não é possivel responder uma mensagem anônima!'
		});
	}

	function mostrarCampos(){
        
        $("#campos").show();
    }

    function esconderCampos(){

        $("#campos").hide();

    }

	function abrirModalEditar(id) {

		var headers = {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}

		var mensagem = $("#mensagem_tr" + id).val();

		$("#mensagem_edit").html(mensagem);

		$.ajax({
			url: "{{ route('painel.falaResidente.ler','') }}/"+id,
			type: "PUT",
			headers: headers,
			error: function(data) {
				console.log(data);
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


			}
		});

	}
    
</script>