<script>

    function validarCPF() {	
        var cpf = $("#cpf").val();
        var cpf2 = $("#cpf2").val();
        cpf = cpf.replace(/[^\d]+/g,'');	
        cpf2 = cpf2.replace(/[^\d]+/g,'');	

        if(cpf != cpf2){
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'O CPF   corresponde com o anterior.'});
            return false;
        }

        if(cpf == ''){ 
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Preencha o campo CPF.'});
            return false;
        } 
        // Elimina CPFs invalidos conhecidos	
        if (cpf.length != 11 || 
            cpf == "00000000000" || 
            cpf == "11111111111" || 
            cpf == "22222222222" || 
            cpf == "33333333333" || 
            cpf == "44444444444" || 
            cpf == "55555555555" || 
            cpf == "66666666666" || 
            cpf == "77777777777" || 
            cpf == "88888888888" || 
            cpf == "99999999999"){
                    Swal.fire({ icon: 'error', title: 'Oops...', text: 'CPF invalido!'});
                    return false;
        }
                
        // Valida 1o digito	
        add = 0;	
        for (i=0; i < 9; i ++)
            add += parseInt(cpf.charAt(i)) * (10 - i);	
            rev = 11 - (add % 11);	
            if (rev == 10 || rev == 11)		
                rev = 0;	
            if (rev != parseInt(cpf.charAt(9))){		
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'CPF invalido!'});
                return false;	
            }
        // Valida 2o digito	
        add = 0;	
        for (i = 0; i < 10; i ++)		
            add += parseInt(cpf.charAt(i)) * (11 - i);	
        rev = 11 - (add % 11);	
        if (rev == 10 || rev == 11)	
            rev = 0;	
        if (rev != parseInt(cpf.charAt(10)))
        {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'CPF invalido!'});
            return false;		
        }
        return true;   
    }

    function mascara_cpf()
    {
        var cpf = document.getElementById('cpf');
        if(cpf.value.length == 3 || cpf.value.length == 7){
            cpf.value += ".";
        }else if(cpf.value.length == 11){
            cpf.value += "-";
        }
    }


</script>