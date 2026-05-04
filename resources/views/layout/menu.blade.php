<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Aside Toolbarl-->
    <div id="kt_aside_toolbar" class="aside-toolbar flex-column-auto">
        <!--begin::User-->
        <div class="aside-user d-flex align-items-sm-center justify-content-center py-5">
            <!--begin::Symbol-->
            <div class="symbol symbol-50px">

                <img src="{{ url('assets/imagens/avatar.png') }}" alt="" />
              
            </div>
            <!--end::Symbol-->
            <!--begin::Wrapper-->
            <div class="aside-user-info flex-row-fluid flex-wrap ms-5">
                <!--begin::Section-->
                <div class="d-flex">
                    <!--begin::Info-->
                    <div class="flex-grow-1 me-2 text-gray-300 ">
                        @auth
                            <b>{{ Auth::user()->name }}</b>
                            <span class="text-gray-600 fw-bold d-block fs-8 mb-1">
                                {{ optional(Auth::user()->empresa)->nome ?: 'Sem empresa vinculada' }}
                            </span>
                            <span class="badge badge-light-primary fs-8">{{ ucfirst(Auth::user()->perfil) }}</span>
                        @endauth
                    </div>
                    <!--end::Info-->
                    
                </div>
                <!--end::Section-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::User-->

        <!--end::Aside user-->
    </div>
    <!--end::Aside Toolbarl-->
    <!--begin::Aside menu-->
    @if(Auth::user()->perfil_id != 1)
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div id="kt_aside_menu_wrapper" class="hover-scroll-overlay-y px-2 my-5 my-lg-5" data-kt-scroll="true"
            data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}"
            data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="5px">
            <!--begin::Menu-->
            <div id="#kt_aside_menu"
                class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                data-kt-menu="true">

                <div class="menu-item">
                    <a class="menu-link" href="{{ route('perfil.edit') }}">
                        <span class="menu-icon">
                            <i class="las la-user-cog fs-2"></i>
                        </span>
                        <span class="menu-title">Meu Perfil</span>
                    </a>
                </div>

                @if(Auth::user()->temPerfil(['admin', 'auditor']))
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('empresas.index') }}">
                        <span class="menu-icon">
                            <i class="las la-building fs-2"></i>
                        </span>
                        <span class="menu-title">Empresas</span>
                    </a>
                </div>
                @endif

                <div class="menu-item">
                    <a class="menu-link" href="{{ route('residuos.index') }}">
                        <span class="menu-icon">
                            <i class="las la-recycle fs-2"></i>
                        </span>
                        <span class="menu-title">Resíduos</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link" href="{{ route('marketplace.index') }}">
                        <span class="menu-icon">
                            <i class="las la-store fs-2"></i>
                        </span>
                        <span class="menu-title">Marketplace</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link" href="{{ route('interesses.index') }}">
                        <span class="menu-icon">
                            <i class="las la-bullseye fs-2"></i>
                        </span>
                        <span class="menu-title">Interesses</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link" href="{{ route('transacoes.index') }}">
                        <span class="menu-icon">
                            <i class="las la-handshake fs-2"></i>
                        </span>
                        <span class="menu-title">Transações</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link" href="{{ route('documentos-transacao.index') }}">
                        <span class="menu-icon">
                            <i class="las la-file-alt fs-2"></i>
                        </span>
                        <span class="menu-title">Documentos</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link" href="{{ route('impactos.index') }}">
                        <span class="menu-icon">
                            <i class="las la-leaf fs-2"></i>
                        </span>
                        <span class="menu-title">Impactos</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link" href="{{ route('avaliacoes.index') }}">
                        <span class="menu-icon">
                            <i class="las la-star fs-2"></i>
                        </span>
                        <span class="menu-title">Avaliações</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link" href="{{ route('dashboard-sustentavel.index') }}">
                        <span class="menu-icon">
                            <i class="las la-chart-line fs-2"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a class="menu-link" href="{{ route('relatorio-carbono.index') }}">
                        <span class="menu-icon">
                            <i class="las la-cloud fs-2"></i>
                        </span>
                        <span class="menu-title">Relatório Carbono</span>
                    </a>
                </div>




                @if (session()->has('menus'))

                    <div class="menu-item">
                        <div class="menu-content pb-2">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">Menu</span>
                        </div>
                    </div>

                    @foreach (Session::get('menus') as $menu)
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">

                            <span class="menu-link">
                                <span class="menu-icon">
                                    {!! $menu['icone'] !!}
                                </span>
                                <span class="menu-title">{{ $menu['nome'] }}</span>
                                <span class="menu-arrow"></span>
                            </span>

                        
                            <div class="menu-sub menu-sub-accordion menu-active-bg">

                       

                                @foreach (Session::get('modulos') as $modulo)
                                    @if ($menu['id'] == $modulo['menu_id'])
                                        @if ($modulo['modulo_pai_id'] == $modulo['menu_id'])
                                            @if ($modulo['rota'] != 'submenu')
                                                 
                                                <div class="menu-item">
                                                    <a class="menu-link" href="{{ route($modulo['rota']) }}">
                                                        <span class="menu-bullet">
                                                            <span class="bullet bullet-dot"></span>
                                                        </span>
                                                        <span class="menu-title">{{ $modulo['modulo'] }}</span>
                                                    </a>
                                                </div>
                                               
                                            @else

                                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                                    <span class="menu-link">
                                                        <span class="menu-bullet">
                                                            <span class="bullet bullet-dot"></span>
                                                        </span>
                                                        <span class="menu-title">{{ $modulo['modulo'] }}</span>
                                                        <span class="menu-arrow"></span>
                                                    </span>
                                        
                                                    <div class="menu-sub menu-sub-accordion menu-active-bg">

                                                        @foreach (Session::get('modulos') as $submenu)
                                                            @if ($modulo['id'] == $submenu['modulo_pai_id'])
                                                                <div class="menu-item">
                                                                    <a class="menu-link"
                                                                        href="{{ route($submenu['rota']) }}">
                                                                        <span class="menu-bullet">
                                                                            <span class="bullet bullet-dot"></span>
                                                                        </span>
                                                                        <span
                                                                            class="menu-title">{{ $submenu['modulo'] }}</span>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        @endforeach

                                                    </div>
                                                </div>
                                               
                                            @endif
                                        @endif
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    @endforeach

                @endif

            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    @endif
    <!--end::Aside menu-->
    <!--begin::Footer-->
    <div id="kt_aside_footer" class="aside-footer flex-column-auto py-5">

        <form class="form w-100" method="post" action="{{ route('painel.logout') }}"> 
            @csrf

            <button type="submit" class="btn btn-custom btn-primary w-100">
                Sair
            </button>

        </form>

    </div>
    <!--end::Footer-->
</div>
