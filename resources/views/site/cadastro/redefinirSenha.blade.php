@include('site.site-layout.header')

<div class="container-lg mt-4">
    <div class="br-breadcrumb">
        <ul class="crumb-list">
            <li class="crumb home"><a class="br-button circle" href="{{ route('site.index')}}">
                    <span class="sr-only">Página inicial</span><i class="fas fa-home"></i></a>
            </li>
            <li class="crumb" data-active="active"><i class="icon fas fa-chevron-right"></i><a href="{{ route('participante.areaParticipante')}}">Redefinir Senha</a>
            </li>
        </ul>
    </div>
</div>

<body>

    <div class="container-sm">
        <!-- Content here -->
        @if($form == 1)
        <div class="form-group p-5" style="width: 30%; margin-left: auto; margin-right: auto;">
            <form class="form" action="{{ route('redefinirSenha.update') }}" method="post">
                @csrf
                <div class="row mt-6">
                    <div class="col-sm">
                        <fieldset class="border-solid-sm rounder-md p-4">
                            <legend class="text-up-02">Redefinir Senha</legend>
                            <div class="row  justify-content-center">
                                <div class="col-md-12">
                                    <div class="br-input"><label>Senha</label>
                                        <input id="token" name="token" type="hidden" value="@isset($token){{$token}}@endisset"/>
                                        <input id="senha" name="senha" type="password" placeholder="Digite sua senha" />
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="br-input"><label for="senha">Confirme a Senha</label>
                                        <input name="confirmarSenha" type="password" placeholder="Confirme sua senha" />
                                    </div>
                                </div>
                            </div>
                            @if (session('error'))
                                <div class="feedback danger justify-content-center" role="alert">
                                    <i class="fas fa-times-circle" aria-hidden="true"></i><span>{{ session('error') }}</span></span>
                                </div>
                            @endif 
                            <div class="row justify-content-center mt-4">
                                <button type="submit" class="br-button primary mr-3">Salvar</button>
                            </div>
                        </fieldset>

                    </div>

                </div>
            </form>
            
        </div>
        @else
        <div class="container-fluid" style="background-color: #F3F3F3;">
            <h2 class="text-center">Área do Participante</h2>
            <div class="container-lg text-center">
                <span class="text-danger text-up-02">O link expirou, solicite um novo link para redefinição de senha.</span>
            </div>
        </div>
        @endif

    </div>

</body>

@include('site.cadastro.js')
@include('site.site-layout.footer')

</html>