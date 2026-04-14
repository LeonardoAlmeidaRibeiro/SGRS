<script>
    Chart.register(ChartDataLabels);

    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

    $.ajax({
        url: "{{ route('painel.grafico') }}",
        type: "GET",
        headers: headers,
        success: function(data) {

            dados = JSON.parse(data);

            gerarGraficoFormaInscricao(dados);
            gerarGraficoFormaConhecimento(dados);
            gerarGraficoTipoPessoa(dados);
            gerarGraficoGenero(dados);
            gerarGraficoCeritificados(dados);
            gerarGraficoEvento(dados);
            gerarGraficoCategoriaEvento(dados);
            gerarGraficoParticipantes(dados);
            gerarGraficoCategoriaProfissional(dados);

        }
    });

    function gerarGraficoFormaInscricao(dados) {



        var ctx = document.getElementById('forma_inscricao').getContext('2d');

        var total_inscricoes = dados.total_inscricoes + ' Inscrições Realizadas';


        //console.log(dados);
        var cor_barra_1 = KTUtil.getCssVariableValue('--bs-primary');
        $("#total_inscricoes").html(total_inscricoes);


        // Chart config
        const config = {
            type: 'doughnut',
            data: {
                labels: ['Presencial', 'Email', 'Telefone', 'Internet', 'Outros'],
                datasets: [{

                    data: [
                        dados.presencial,
                        dados.email,
                        dados.telefone,
                        dados.internet,
                        dados.outros,
                    ],
                    backgroundColor: [
                        '#6993ff',
                        '#1bc5bd',
                        '#ffa800',
                        '#f64e60',
                        '#808080',
                    ],
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        display: true,
                        backgroundColor: '#FFFFFF',
                        borderRadius: 3,
                        font: {
                            color: 'red',
                            weight: 'bold',
                        }
                    },

                    legend: {
                        position: 'right'
                    }
                }
            }
        };

        var myChart = new Chart(ctx, config);

    }

    function gerarGraficoFormaConhecimento(dados) {



        var ctx = document.getElementById('forma_conhecimento').getContext('2d');

        var total_inscricoes_conhecimento = dados.total_inscricoes + ' Inscrições Realizadas';


        //console.log(dados);
        var cor_barra_1 = KTUtil.getCssVariableValue('--bs-primary');
        $("#total_inscricoes_conhecimento").html(total_inscricoes_conhecimento);


        // Chart config
        const config = {
            type: 'doughnut',
            data: {
                labels: ['Internet', 'Radio', 'Jornal', 'Revista', 'Intranet', 'Amigos', 'Conhecidos', 'Outros'],
                datasets: [{

                    data: [
                        dados.conhecimento_internet,
                        dados.conhecimento_radio,
                        dados.conhecimento_jornal,
                        dados.conhecimento_revista,
                        dados.conhecimento_internet_hfa,
                        dados.conhecimento_amigos,
                        dados.conhecimento_conhecidos,
                        dados.conhecimento_outros,
                    ],
                    backgroundColor: [
                        '#6993ff',
                        '#1bc5bd',
                        '#b0ee65',
                        '#ffa800',
                        '#fd784f',
                        '#f64e60',
                        '#bd42ad',
                        '#808080',
                    ],
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        display: true,
                        backgroundColor: '#FFFFFF',
                        borderRadius: 3,
                        font: {
                            color: 'red',
                            weight: 'bold',
                        }
                    },
                    legend: {
                        position: 'right'
                    }
                }
            }
        };

        var myChart = new Chart(ctx, config);

    }

    function gerarGraficoTipoPessoa(dados) {



        var ctx = document.getElementById('tipo_participante').getContext('2d');

        var total_participantes = dados.total_participantes + ' Participantes no Sistema';


        //console.log(dados);
        var cor_barra_1 = KTUtil.getCssVariableValue('--bs-primary');
        $("#total_inscricoes_participantes").html(total_participantes);


        // Chart config
        const config = {
            type: 'doughnut',
            data: {
                labels: ['Servidor Militar', 'Servidor Civil', 'Públ. Ext. Militar', 'Púb. Ext. Civil'],
                datasets: [{

                    data: [
                        dados.militar,
                        dados.civil,
                        dados.publico_externo_militar,
                        dados.publico_externo_civil,

                    ],
                    backgroundColor: [
                        '#6993ff',
                        '#1bc5bd',
                        '#ffa800',
                        '#f64e60',
                    ],
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        display: true,
                        backgroundColor: '#FFFFFF',
                        borderRadius: 3,
                        font: {
                            color: 'red',
                            weight: 'bold',
                        }
                    },

                    legend: {
                        position: 'right'
                    }
                }
            }
        };

        var myChart = new Chart(ctx, config);

    }

    function gerarGraficoGenero(dados) {


        var ctx = document.getElementById('generos').getContext('2d');

        var total_participantes = dados.total_participantes + ' Participantes no Sistema';


        //console.log(dados);
        var cor_barra_1 = KTUtil.getCssVariableValue('--bs-primary');
        $("#total_inscricoes_generos").html(total_participantes);


        // Chart config
        const config = {
            type: 'doughnut',
            data: {
                labels: ['Masculino', 'Feminino', 'Outros'],
                datasets: [{

                    data: [
                        dados.masculino,
                        dados.feminino,
                        dados.outros_generos,

                    ],
                    backgroundColor: [
                        '#7ea1fd',
                        '#f66776',
                        '#808080',
                    ],
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        display: true,
                        backgroundColor: '#FFFFFF',
                        borderRadius: 3,
                        font: {
                            color: 'red',
                            weight: 'bold',
                        }
                    },

                    legend: {
                        position: 'right'
                    }
                }
            }
        };

        var myChart = new Chart(ctx, config);

    }

    function gerarGraficoCeritificados(dados) {


        var ctx = document.getElementById('certificados_emitidos').getContext('2d');

        var total_inscricoes = dados.total_inscricoes + ' Inscrições Realizadas';


        //console.log(dados);
        var cor_barra_1 = KTUtil.getCssVariableValue('--bs-primary');
        $("#total_inscricoes_certificados").html(total_inscricoes);


        // Chart config
        const config = {
            type: 'doughnut',
            data: {
                labels: ['Emitidos', 'Não Emitidos'],
                datasets: [{

                    data: [
                        dados.certificado_emitido,
                        dados.falta_emitir,

                    ],
                    backgroundColor: [
                        '#1bc5bd',
                        '#f64e60',
                    ],
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        display: true,
                        backgroundColor: '#FFFFFF',
                        borderRadius: 3,
                        font: {
                            color: 'red',
                            weight: 'bold',
                        }
                    },

                    legend: {
                        position: 'right'
                    }
                }
            }
        };

        var myChart = new Chart(ctx, config);

    }

    function gerarGraficoCategoriaEvento(dados) {


        var ctx = document.getElementById('categoria_evento').getContext('2d');

        var total_eventos = dados.total_eventos + ' Categorias de Evento no Sistema';


        //console.log(dados);
        var cor_barra_1 = KTUtil.getCssVariableValue('--bs-primary');
        $("#total_categoria_eventos").html(total_eventos);


        // Chart config
        const config = {
            type: 'doughnut',
            data: {
                labels: ['Palestra ', 'Debate', 'Outros'],
                datasets: [{

                    data: [
                        dados.evento_categoria_palestra,
                        dados.evento_categoria_debate,
                        dados.evento_categoria_outros,

                    ],
                    backgroundColor: [
                        '#7ea1fd',
                        '#f66776',
                        '#808080',
                    ],
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        display: true,
                        backgroundColor: '#FFFFFF',
                        borderRadius: 3,
                        font: {
                            color: 'red',
                            weight: 'bold',
                        }
                    },

                    legend: {
                        position: 'right'
                    }
                }
            }
        };

        var myChart = new Chart(ctx, config);

    }

    function gerarGraficoCategoriaProfissional(dados) {


        var ctx = document.getElementById('categoria_profissional').getContext('2d');

        var total_participantes = dados.total_participantes + ' Profissionais Participantes';


        //console.log(dados);
        var cor_barra_1 = KTUtil.getCssVariableValue('--bs-primary');
        $("#total_categoria_profissional").html(total_participantes);


        // Chart config
        const config = {
            type: 'doughnut',
            data: {
                labels: ['Prof. Saúde ', 'Estudante','Pesquisador','Gestor de Saúde','Docente', 'Outros'],
                datasets: [{

                    data: [
                        dados.participante_profissional_saude,
                        dados.participante_estudante,
                        dados.participante_pesquisador,
                        dados.participante_gestor_saude,
                        dados.participante_docente,
                        dados.participante_outros,

                    ],
                    backgroundColor: [
                        '#f64e60',
                        '#6993ff',
                        '#b0ee65',
                        '#ffa800',
                        '#bd42ad',
                        '#808080',
                    ],
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        display: true,
                        backgroundColor: '#FFFFFF',
                        borderRadius: 3,
                        font: {
                            color: 'red',
                            weight: 'bold',
                        }
                    },

                    legend: {
                        position: 'right'
                    }
                }
            }
        };

        var myChart = new Chart(ctx, config);

    }

    function gerarGraficoEvento(dados) {

        var eventos_ativos = dados.evento_ativo;
        var eventos_inativos = dados.evento_inativo;
        var eventos_totais = eventos_ativos + eventos_inativos;

        $("#total_eventos_ativos").html(eventos_ativos + ' Ativos');
        $("#total_eventos_inativos").html(eventos_inativos + ' Inativos');
        $("#total_eventos").html('Total de ' + eventos_totais + ' Eventos ');

    }

    function gerarGraficoParticipantes(dados) {

        var militar = dados.militar;
        var civil = dados.civil;
        var publico_externo_militar = dados.publico_externo_militar;
        var publico_externo_civil = dados.publico_externo_civil;
        var total_participantes = dados.total_participantes;

        $("#total_participante_militar").html(militar + ' Militar');
        $("#total_participante_civil").html(civil + ' Civil');
        $("#total_participante_ext_militar").html(publico_externo_militar + ' Militar Externo');
        $("#total_participante_ext_civil").html(publico_externo_civil + ' Civil Externo');
        $("#total_participantes_card").html('Total de ' + total_participantes + ' Participantes');

    }
</script>