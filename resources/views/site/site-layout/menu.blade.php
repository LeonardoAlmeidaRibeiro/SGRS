

<div class="row">
    <div class="br-menu">
    <div class="menu-container">
        <div class="menu-panel">
            <div class="menu-header">
                <div class="menu-title"><img src="{{ url('assets/imagens/logo-govbr.png') }}" alt="logo" />
                    <span>Site de Gestão de Eventos</span>
                </div>
                <div class="menu-close">
                    <button class="br-button circle" type="button" aria-label="Fechar o menu" data-dismiss="menu">
                        <i class="fas fa-times" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <nav class="menu-body">
                <div>
                    <a class="menu-item" href="{{ route('site.index') }}">
                        <span class="icon">
                            <i class="fas fa-home"></i>
                        </span>
                        <span class="content">Home</span>
                    </a>
                </div>
                <div class="br-divider">
                    <a class="menu-item" href="{{ route('contato.index') }}">
                        <span class="icon">
                            <i class="fas fa-headset" aria-hidden="true"></i>
                        </span>
                        <span class="content">Fale Conosco</span>
                    </a>
                </div>
                <div class="br-divider">
                    <a class="menu-item" href="{{ route('falaResidente.index') }}">
                        <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="21px" viewBox="0 0 448 512" id="icone_fala_residente">
                            <style>#icone_fala_residente{fill:#23509f}</style>
                            <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-96 55.2C54 332.9 0 401.3 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7c0-81-54-149.4-128-171.1V362c27.6 7.1 48 32.2 48 62v40c0 8.8-7.2 16-16 16H336c-8.8 0-16-7.2-16-16s7.2-16 16-16V424c0-17.7-14.3-32-32-32s-32 14.3-32 32v24c8.8 0 16 7.2 16 16s-7.2 16-16 16H256c-8.8 0-16-7.2-16-16V424c0-29.8 20.4-54.9 48-62V304.9c-6-.6-12.1-.9-18.3-.9H178.3c-6.2 0-12.3 .3-18.3 .9v65.4c23.1 6.9 40 28.3 40 53.7c0 30.9-25.1 56-56 56s-56-25.1-56-56c0-25.4 16.9-46.8 40-53.7V311.2zM144 448a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"/>
                        </svg>
                        </span>
                        <span class="content">Fala Residente</span>
                    </a>
                </div>
                @if(session()->get('cpf') != "")
                    <div class="br-divider">
                        <a class="menu-item" href="{{ route('participante.areaParticipante') }}">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                </svg>
                            </span>
                            <span class="content">
                                {{ $nome = strstr(session('nome'), ' ', true) ?: session('nome') }}
                            </span>
                        </a>
                    </div>
                @else
                    <div class="br-divider">
                        <a class="menu-item" href="{{ route('cadastro.index',0) }}">
                            <span class="icon">
                                <i class="fas fa-user"></i>
                            </span>
                            <span class="content">Area do Participante</span>
                        </a>
                    </div>
                @endif
            </nav>
            <div class="menu-footer br-divider">
                <div class="social-network">
                    <div class="social-network-title">Redes Sociais</div>
                    <div class="d-flex">
                        <a class="br-button circle" target="$_blank" href="https://www.facebook.com/hfasaude/" aria-label="Compartilhar por Facebook">
                            <i class="fab fa-facebook-f" aria-hidden="true"></i>
                        </a>
                        <a class="br-button circle" target="$_blank" href="https://www.instagram.com/hfasaude/" aria-label="Compartilhar por Instagram">
                            <i class="fab fa-brands fa-instagram"></i>
                        </a>
                        <a class="br-button circle" target="$_blank" href="https://www.youtube.com/c/HospitaldasFor%C3%A7asArmadas" aria-label="Compartilhar por YouTube">
                            <i class="fab fa-brands fa-youtube"></i>
                        </a>
                        <a class="br-button circle" target="$_blank" href="https://www.flickr.com/people/142776407@N07/" aria-label="Compartilhar por flickr">
                            <i class="fab fa-brands fa-flickr"></i>
                        </a>
                    </div>
                </div>
                <div class="menu-info">
                    <div class="text-down-01 text-medium pb-3"><strong>HFA - Hospital das Forças Armadas</strong> &nbsp; | &nbsp; Todos os direitos reservados</div>
                </div>
            </div>
        </div>
        <div class="menu-scrim" data-dismiss="menu" tabindex="0"></div>
    </div>
    </div>
</div>