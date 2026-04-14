@include('site.site-layout.header')


<div class="container-lg mt-4">
    <div class="br-breadcrumb">
        <ul class="crumb-list">
            <li class="crumb home"><a class="br-button circle" href="{{ route('site.index')}}">
                    <span class="sr-only">Página inicial</span><i class="fas fa-home"></i></a>
            </li>
            <li class="crumb" data-active="active"><i class="icon fas fa-chevron-right"></i><a href="{{ route('participante.areaParticipante')}}">Área do Participante</a>
            </li>
        </ul>
    </div>
</div>
<div class="container-fluid pb-3" style="background-color: #F3F3F3;">
    <h2 class="text-center">Fale Conosco</h2>
    <div class="container-lg text-center mb-5">
        <span class="text-up-02">
            A Direção Técnica de Ensino e Pesquisa do Hospital das Forças Armadas conta com você para
            melhorar a qualidade dos nossos serviços prestados.
        </span>
    </div>
</div>

<div class="container-lg">
    <!-- Content here -->
    <div class="form-group p-5">
        <form class="form" method="post" action="#">
            @csrf 
            <div class="row mt-6">
                <div class="col-sm">
                    <fieldset class="border-solid-sm rounder-md p-4">
                        <legend class="text-up-02">Dados Pessoais</legend>
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
                            <div class="br-input"><label for="telefone">Telefone</label>
                                <input name="telefone" id="telefone" type="telefone" maxlength="15" onkeyup="handlePhone(event)" value="@if(session()->get('cpf') != '') {{$participante->first()->telefone}} @endif" />
                            </div>
                        </div>
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
                            <button class="br-button primary mr-3" id="enviarInscr" type="button" onclick="return salvar()">Enviar</button>
                        </div>
                    </fieldset>
                </div>
                <div class="col-sm">
                    <div>
                        <fieldset class="border-solid-sm rounder-md p-4">
                            <legend class="text-up-02">Dados para Contato</legend>
                            <div>
                                <div class="col-md-12 ">
                                    <span class="text-weight-semi-bold text-up-01">Telefone:</span>
                                    <span>(61) 3966-2408</span>
                                </div>
                                <div class="col-md-12">
                                    <span class="text-weight-semi-bold text-up-01">E-mail:</span>
                                    <span>cursoseeventos@hfa.mil.br</span>
                                </div>
                                <div class="col-md-12 mt-2 text-wrap">
                                    <span class="text-weight-semi-bold text-up-01">Endereço: </span>
                                    <span> A/C Subdivisão de Capacitação - Hospital das Forças Armadas - Direção Técnica de Ensino e Pesquisa, St. Sudoeste - Cruzeiro / Sudoeste / Octogonal, Brasília - DF,
                                        70297-400.
                                    </span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <iframe class="border-solid-sm rounder-md" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15356.232368739316!2d-47.93172465!3d-15.800890599999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x935a307eaaaaaaab%3A0xa3c843ee78fc311f!2sHospital%20das%20For%C3%A7as%20Armadas!5e0!3m2!1spt-BR!2sbr!4v1675858219345!5m2!1spt-BR!2sbr" width="100%" height="53%" style="border:0;" allowfullscreen="" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </form>
    </div>

</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<link rel="stylesheet" href="assets/node_modules/@govbr-ds/core/dist/core.css" />
<script src="assets/node_modules/@govbr-ds/core/dist/core.js"></script>

@include('site.contato.js')

@include('site.site-layout.footer')