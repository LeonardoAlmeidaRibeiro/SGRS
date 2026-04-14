@include('site.site-layout.header')


<div class="container-lg mt-4">
    <div class="br-breadcrumb">
        <ul class="crumb-list">
            <li class="crumb home"><a class="br-button circle" href="{{ route('site.index')}}">
                    <span class="sr-only">Página inicial</span><i class="fas fa-home"></i></a>
            </li>
            <li class="crumb" data-active="active"><i class="icon fas fa-chevron-right"></i><a href="{{ route('falaResidente.index')}}">Fala Residente</a>
            </li>
        </ul>
    </div>
</div>
<div class="container-fluid pb-3" style="background-color: #F3F3F3;">
    <h2 class="text-center">Fala Residente</h2>
    <div class="container-lg text-center mb-5">
        <span class="text-up-02">
            A Direção Técnica de Ensino e Pesquisa do Hospital das Forças Armadas conta com você para
            melhorar a qualidade dos nossos serviços prestados.
        </span>
    </div>
</div>

<div class="container-lg" style="width: 50%;">
    <!-- Content here -->
    <div class="form-group p-5">
        <form class="form" method="post" action="#">
            @csrf 
            <div class="row mt-6">
                <div class="col-sm">
                    <fieldset class="border-solid-sm rounder-md p-4">
                        <legend class="text-up-02">Fala Residente</legend>
                        <div class="col-md-12 mb-2" id="especialidade_id" >
                                <div class="br-select" >
                                    <div class="br-input">
                                        <label for="select-simple">Tipo de Formulário: (Identificado/Anônimo)</label>
                                        <input id="select-simple" type="text" placeholder="Selecione o item" />
                                        <button class="br-button" type="button" aria-label="Exibir lista" tabindex="-1" data-trigger="data-trigger"><i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="br-list" tabindex="0">
                                        
                                        <div class="br-item" tabindex="-1">
                                            <div class="br-radio">
                                                <input id="Identificado" type="radio" name="Identificado" value="Identificado" onclick="mostrarCampos()"/>
                                                <label for="Identificado">Identificado</label>
                                            </div>
                                        </div>

                                        <div class="br-item" tabindex="-1">
                                            <div class="br-radio">
                                                <input id="Anonimo" type="radio" name="Anonimo" value="Anonimo" onclick="esconderCampos()"/>
                                                <label for="Anonimo">Anônimo</label>
                                            </div>
                                        </div>
                                     
                                    </div>
                                </div>
                            </div>
                        <div id="campos">
                            <div class="col-md-12 mb-2">
                                <div class="br-input"><label for="name">Nome</label>
                                    <input name="nome" id="nome" placeholder="Digite seu nome" type="text" value="@if(session()->get('nome') != '') {{$nome}} @endif" />
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="br-input"><label for="email">E-mail</label>
                                    <input name="email" id="email" placeholder="Digite seu email" type="email" value="@if(session()->get('email') != '') {{$email}} @endif" />
                                </div>
                            </div>
                  
                            <div class="col-md-12 mb-2">
                                <div class="br-input"><label for="telefone">Clínica</label>
                                    <input name="clinica" id="clinica" placeholder="Digite o nome da sua clínica" type="text" />
                                </div>
                            </div>
                        </div><br>
                        <div class="col-md-12">
                            <div class="br-textarea large">
                                <label for="textarea-density-id2">Mensagem</label>
                                <textarea name="mensagem" id="mensagem"></textarea>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-4">
                            <div class="g-recaptcha" data-sitekey="6Ld4LCYlAAAAAIE3_kLZ8qrBpdZZoueOophPmVJe" id="recaptcha-token"></div>
                        </div>
                        <div class="row justify-content-center mt-4">
                            <button class="br-button primary mr-3" id="enviarInscr" type="button" onclick="return executarModalCriar()">Enviar</button>
                        </div>
                    </fieldset>
                </div>
               
            </div>
        </form>
    </div>

</div>

<script>
    const selectList = []
    const notFoundElement = `
        <div class="br-item not-found">
        <div class="container">
        <div class="row">
            <div class="col">
            <p><strong>Ops!</strong> Não encontramos o que você está procurando!</p>
            </div>
        </div>
        </div>
        </div>
        `
    for (const brSelect of window.document.querySelectorAll('.br-select')) {
        const brselect = new core.BRSelect('br-select', brSelect, notFoundElement)
        //Exemplo de uso de listener do select
        brSelect.addEventListener('onChange', function(e) {})
        selectList.push(brselect)
    }
</script>


<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<link rel="stylesheet" href="assets/node_modules/@govbr-ds/core/dist/core.css" />
<script src="assets/node_modules/@govbr-ds/core/dist/core.js"></script>

@include('site.fala_residente.js')

@include('site.site-layout.footer')