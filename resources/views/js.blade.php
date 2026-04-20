    <!--begin::Page Custom Javascript-->
<script>
    console.log('oi');
$(document).ready(function() {

    // =============================
    // Máscaras
    // =============================
    $('#cnpj').mask('00.000.000/0000-00');
    $('#telefone').mask('(00) 00000-0000');
    $('#cep').mask('00000-000');

    // =============================
    // Loading
    // =============================
    function mostrarCarregamento(msg) {
        removerCarregamento();

        $('body').append(`
            <div id="loading-message" style="
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(0,0,0,0.8);
                color: #fff;
                padding: 15px 25px;
                border-radius: 8px;
                z-index: 9999;
            ">
                ${msg}
            </div>
        `);
    }

    function removerCarregamento() {
        $('#loading-message').remove();
    }

    // =============================
    // CEP
    // =============================
    $('#cep').on('blur', function() {

        let cep = $(this).val().replace(/\D/g, '');

        if (cep.length !== 8) return;

        mostrarCarregamento('Buscando CEP...');

        $.getJSON(`https://viacep.com.br/ws/${cep}/json/`)
        .done(function(data) {

            if (data.erro) {
                removerCarregamento();
                alert('CEP não encontrado');
                return;
            }

            // Preenche endereço
            $('#endereco').val(data.logradouro);

            // =============================
            // Busca cidade/estado no backend
            // =============================
            $.ajax({
                url: '/buscar-cidade',
                method: 'GET',
                data: {
                    cidade: data.localidade,
                    uf: data.uf
                },
                success: function(res) {

                    if (res.estado_id) {
                        $('#estado').val(res.estado_id).trigger('change');
                    }

                    if (res.cidade_id) {
                        $('#cidade').val(res.cidade_id).trigger('change');
                    }
                }
            });

            // =============================
            // Lat / Long
            // =============================
            buscarLatLong(data.logradouro, data.localidade, data.uf);

        })
        .fail(function() {
            removerCarregamento();
            alert('Erro ao buscar CEP');
        });

    });

    // =============================
    // LAT LONG
    // =============================
    function buscarLatLong(endereco, cidade, uf) {

        let query = `${endereco}, ${cidade}, ${uf}, Brasil`;

        $.getJSON(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
        .done(function(data) {

            removerCarregamento();

            if (data.length > 0) {
                $('#latitude').val(data[0].lat);
                $('#longitude').val(data[0].lon);
            }
        })
        .fail(function() {
            removerCarregamento();
        });
    }

    // =============================
    // VALIDAÇÃO FORM
    // =============================
    $('form').on('submit', function(e) {

        let senha = $('#senha').val();
        let confirmacao = $('input[name="senha_confirmacao"]').val();

        if (senha !== confirmacao) {
            e.preventDefault();
            alert('Senhas não coincidem');
            return false;
        }

        if (!$('input[name="termos"]').is(':checked')) {
            e.preventDefault();
            alert('Aceite os termos');
            return false;
        }

        mostrarCarregamento('Cadastrando...');
    });

});
</script>