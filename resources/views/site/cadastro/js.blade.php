<script>
    function mascara_cpf() {
        var cpf = document.getElementById('cpf');
        if (cpf.value.length == 3 || cpf.value.length == 7) {
            cpf.value += ".";
        } else if (cpf.value.length == 11) {
            cpf.value += "-";
        }
    }

    function enviarLogin(){

        $("#enviarLog").html('Aguarde...');
        $('#enviarLog').prop('disabled', true); //Desabilita o botão

    }

</script>