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
                            @if (Session::has('usuario'))
                                @php
                                    $dados_usuario = Session::get('usuario');
                                @endphp
                                <b>{{ $dados_usuario['nome'] }}</b>
                            @endif
                        <span class="text-gray-600 fw-bold d-block fs-8 mb-1">
                            @if (Session::has('usuario'))
                                Bem vindo ao SGE!
                            @endif
                        </span>
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
