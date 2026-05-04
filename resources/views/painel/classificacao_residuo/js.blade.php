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

    function badgeSimNao(valor) {
        return valor ? '<span class="badge badge-success">Sim</span>' : '<span class="badge badge-secondary">Nao</span>';
    }

    function badgeClasse(valor) {
        return valor === 'perigoso' ? '<span class="badge badge-danger">Perigoso</span>' : '<span class="badge badge-info">Nao perigoso</span>';
    }

    function abrirModalEditar(id) {
        var classe = $("#celula_classe_nbr10004_" + id).text().trim() === "Perigoso" ? "perigoso" : "nao_perigoso";

        $("#id_edit").val(id);
        $("#nome_edit").val($("#celula_nome_" + id).text().trim());
        $("#codigo_edit").val($("#celula_codigo_" + id).text().trim());
        $("#classe_nbr10004_edit").val(classe);
        $("#codigo_cer_edit").val($("#celula_codigo_cer_" + id).text().trim());
        $("#exige_mtr_edit").prop("checked", $("#celula_exige_mtr_" + id).text().trim() === "Sim");
        $("#exige_cadri_edit").prop("checked", $("#celula_exige_cadri_" + id).text().trim() === "Sim");
    }

    function executarModalEditar() {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };

        var id = $("#id_edit").val();
        var payload = {
            nome: $("#nome_edit").val(),
            codigo: $("#codigo_edit").val(),
            classe_nbr10004: $("#classe_nbr10004_edit").val(),
            codigo_cer: $("#codigo_cer_edit").val(),
            exige_mtr: $("#exige_mtr_edit").is(":checked") ? 1 : 0,
            exige_cadri: $("#exige_cadri_edit").is(":checked") ? 1 : 0
        };

        $.ajax({
            url: "{{ url('/painel/classificacoes-residuo') }}/" + id,
            type: "PUT",
            data: payload,
            headers: headers,
            error: function(data) {
                var message = 'Erro ao atualizar a classificacao.';
                if (data.status === 422) {
                    message = '';
                    $.each(data.responseJSON.errors, function(campo, conteudo) {
                        message = message + conteudo + '\n';
                    });
                }
                Swal.fire({ icon: 'error', title: 'Oops...', text: message });
            },
            success: function(data) {
                $('#modal_editar').modal('toggle');

                if (data.success == true) {
                    $("#celula_nome_" + id).html(payload.nome);
                    $("#celula_codigo_" + id).html(payload.codigo);
                    $("#celula_classe_nbr10004_" + id).html(badgeClasse(payload.classe_nbr10004));
                    $("#celula_codigo_cer_" + id).html(payload.codigo_cer);
                    $("#celula_exige_mtr_" + id).html(badgeSimNao(payload.exige_mtr == 1));
                    $("#celula_exige_cadri_" + id).html(badgeSimNao(payload.exige_cadri == 1));
                    Swal.fire({ icon: 'success', title: 'Sucesso!', text: data.message });
                } else {
                    Swal.fire({ icon: 'error', title: 'Oops...', text: data.message });
                }
            }
        });
    }

    function executarModalCriar() {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };

        var payload = {
            nome: $("#nome").val(),
            codigo: $("#codigo").val(),
            classe_nbr10004: $("#classe_nbr10004").val(),
            codigo_cer: $("#codigo_cer").val(),
            exige_mtr: $("#exige_mtr").is(':checked') ? 1 : 0,
            exige_cadri: $("#exige_cadri").is(':checked') ? 1 : 0
        };

        if (payload.nome == '') {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Preencha o campo Nome' });
            return false;
        }

        if (payload.codigo == '') {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Preencha o campo Codigo' });
            return false;
        }

        $.ajax({
            url: "{{ route('classificacoes-residuo.store') }}",
            type: "POST",
            data: payload,
            headers: headers,
            error: function(data) {
                var message = 'Erro ao salvar a classificacao. Tente novamente.';
                if (data.status === 422) {
                    message = '';
                    $.each(data.responseJSON.errors, function(campo, conteudo) {
                        message = message + conteudo + '\n';
                    });
                }
                Swal.fire({ icon: 'error', title: 'Oops...', text: message });
            },
            success: function(data) {
                $('#modal_cadastro').modal('toggle');

                if (data.success == true) {
                    $("#nome").val("");
                    $("#codigo").val("");
                    $("#classe_nbr10004").val("nao_perigoso");
                    $("#codigo_cer").val("");
                    $("#exige_mtr").prop('checked', false);
                    $("#exige_cadri").prop('checked', false);

                    var novoRegistro = '<tr id="tr_' + data.data.id + '">' +
                        '<td class="ps-4"><a href="#" onClick="return abrirModalEditar(' + data.data.id + ');" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6" data-bs-toggle="modal" data-bs-target="#modal_editar"><div id="celula_nome_' + data.data.id + '">' + data.data.nome + '</div></a></td>' +
                        '<td class="ps-4"><a href="#" onClick="return abrirModalEditar(' + data.data.id + ');" class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6" data-bs-toggle="modal" data-bs-target="#modal_editar"><div id="celula_codigo_' + data.data.id + '">' + data.data.codigo + '</div></a></td>' +
                        '<td><div id="celula_classe_nbr10004_' + data.data.id + '">' + badgeClasse(data.data.classe_nbr10004) + '</div></td>' +
                        '<td><div id="celula_codigo_cer_' + data.data.id + '">' + (data.data.codigo_cer || '') + '</div></td>' +
                        '<td><div id="celula_exige_mtr_' + data.data.id + '">' + badgeSimNao(data.data.exige_mtr) + '</div></td>' +
                        '<td><div id="celula_exige_cadri_' + data.data.id + '">' + badgeSimNao(data.data.exige_cadri) + '</div></td>' +
                        '<td class="text-end"><div class="card-toolbar"><a href="#" class="btn btn-sm btn-light-primary" onClick="return abrirModalEditar(' + data.data.id + ');" data-bs-toggle="modal" data-bs-target="#modal_editar">Editar</a><button type="button" class="btn btn-sm btn-light-danger" onClick="return excluir(' + data.data.id + ');">Excluir</button></div></td>' +
                        '</tr>';

                    $("#tabela tbody").prepend(novoRegistro);
                    Swal.fire({ icon: 'success', title: 'Sucesso!', text: data.message || 'Classificacao salva com sucesso!', timer: 2000, showConfirmButton: false });
                } else {
                    Swal.fire({ icon: 'error', title: 'Oops...', text: data.message || 'Erro ao salvar classificacao.' });
                }
            }
        });
    }

    function excluir(id) {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        };

        Swal.fire({
            title: 'Tem certeza que deseja excluir?',
            text: "Nao sera possivel reverter essa acao.",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir!'
        }).then(function(result) {
            if (result.isConfirmed || result.value) {
                $.ajax({
                    url: "{{ url('/painel/classificacoes-residuo') }}/" + id,
                    type: "DELETE",
                    headers: headers,
                    success: function(data) {
                        if (data.success == true) {
                            $('#tr_' + id).remove();
                            Swal.fire({ icon: 'success', title: 'Sucesso!', text: data.message });
                        } else {
                            Swal.fire({ icon: 'error', title: 'Oops...', text: data.message });
                        }
                    }
                });
            }
        });
    }
</script>
