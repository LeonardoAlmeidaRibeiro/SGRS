<!DOCTYPE html>
<html lang="pt-br">

<style>
    .dark-mode {
        background: #242737 !important;
        color: white !important;

    }
</style>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Font Rawline-->
    <link rel="stylesheet" href="https://cdngovbr-ds.estaleiro.serpro.gov.br/design-system/fonts/rawline/css/rawline.css" />
    <!-- Font Raleway-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900&amp;display=swap" />
    <!-- Design System GOV.BR CSS-->
    <link rel="stylesheet" href="assets/node_modules/@govbr-ds/core/dist/core.css" />

    <!-- Fontawesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" />

    <link href="{{ url('assets/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    {{-- <link rel="stylesheet" href=" {{ URL::asset('css/eventos.css') }}" /> --}}
    <title>Eventos HFA</title>
</head>

<body>
    <div class="template-base">
        <header class="br-header" data-sticky="data-sticky">
            <div class="container-lg">
                <div class="header-top">
                    <div class="header-logo"><img src="{{ url('assets/imagens/logo-govbr.png') }}" alt="logo" />
                        <span class="br-divider vertical"></span>
                        <div class="header-sign">Ministério da Defesa</div>
                    </div>
                    <div class="header-actions">
                        <div class="header-links dropdown">
                            <button class="br-button circle small" type="button" data-toggle="dropdown" aria-label="Abrir Acesso Rápido"><i class="fas fa-ellipsis-v" aria-hidden="true"></i>
                            </button>
                            <div class="br-list">
                                <div class="header">
                                    <div class="title">Acesso Rápido</div>
                                </div>
                                <a class="br-item" href="{{ route('site.index') }}">Home</a>
                                <a class="br-item" href="{{ route('contato.index') }}">Fale Conosco</a>
                                <a class="br-item" href="{{ route('falaResidente.index') }}">Fala Residente</a>
                            </div>
                        </div>
                        <span class="br-divider vertical mx-half mx-sm-1"></span>
                        <div class="header-search-trigger">
                            <button class="br-button circle" type="button" aria-label="Abrir Busca" data-toggle="search" data-target=".header-search"><i class="fas fa-search" aria-hidden="true"></i>
                            </button>
                        </div>


                        @if(session()->get('cpf') != "")

                        <div class="header-login">
                            <div class="header-sign-in">
                                <a class="br-sign-in small button primary" href="{{ route('participante.areaParticipante') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                    </svg> &nbsp;{{ $nome = strstr(session('nome'), ' ', true) ?: session('nome') }}
                                 

                                </a>
                            </div>
                            <div class="header-avatar"></div>

                        </div>

                        <div class="header-login">
                            <div class="header-sign-in">
                                <a class="br-sign-in small button danger" href="{{ route('sair') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-x" viewBox="0 0 16 16">
                                        <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
                                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm-.646-4.854.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 0 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 .708-.708Z" />
                                    </svg>&nbsp; Sair
                                </a>
                            </div>
                            <div class="header-avatar"></div>

                        </div>
                        @else
                        <div class="header-login">
                            <div class="header-sign-in">
                                <a class="br-sign-in small button primary" href="{{ route('cadastro.index',0) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                    </svg> &nbsp;Área do Participante
                                </a>
                            </div>
                            <div class="header-avatar"></div>

                        </div>
                        @endif
                    </div>
                </div>

                <div class="header-bottom">
                    <div class="header-menu">
                        <div class="header-menu-trigger">
                            <div id="main-navigation" class="br-menu">
                                @include('site.site-layout.menu')
                            </div>
                            <button class="br-button small circle" type="button" aria-label="Menu" data-toggle="menu" data-target="#main-navigation" id="navigation"><i class="fas fa-bars" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="header-info">
                            <div class="header-title">Hospital das Forças Armadas - HFA</div>
                            <div class="header-subtitle">Seja Bem-vindo ao Sistema de Eventos!</div>
                        </div>
                    </div>
                    <div class="header-search">
                        <form action="{{ route('buscarEvento.index') }}" method="post">
                            @csrf
                            <div class="br-input has-icon">
                                <input name="searchbox" type="text" placeholder="O que você procura?" />
                                <button class="br-button circle small" type="button" aria-label="Pesquisar"><i class="fas fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </form>
                        <button class="br-button circle search-close ml-1" type="button" aria-label="Fechar Busca" data-dismiss="search"><i class="fas fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <script src="assets/node_modules/@govbr-ds/core/dist/core.js"></script>
        <script>
            function myFunction() {
                var i,
                    tags = document.getElementsByTagName("*"),
                    total = tags.length;
                for (i = 0; i < total; i++) {
                    tags[i].style.background = '#242737';
                    tags[i].style.color = 'white';

                }

            }

            const headerList = []
            for (const brHeader of window.document.querySelectorAll('.br-header')) {
                headerList.push(new core.BRHeader('br-header', brHeader))
            }

            const menuList = []
            for (const brMenu of window.document.querySelectorAll('.br-menu')) {
                menuList.push(new core.BRMenu('br-menu', brMenu))
            }

        </script>