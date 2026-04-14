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

@if($parametro != 0)
<div class="container-fluid" style="background-color: #F3F3F3;">
    <h2 class="text-center">{{$evento->first()->nome_evento}}</h2>
    <div class="container-lg text-center">
        <span class="text-up-02">
            Data do evento:&nbsp;{{date('d/m/Y', strtotime($evento->first()->data_evento))}} <br>
            Local:&nbsp;{{$evento->first()->unidadeEvento->first()->nome}}
        </span><br><br><br>
    </div>
</div>
@endif

<body>

    <div class="container-sm">
        <!-- Content here -->
        <div class="form-group p-5" style="width: 30%; margin-left: auto; margin-right: auto;">

            <form class="form" action="{{ route('autenticar.Participante') }}" method="post" autocomplete="off" onSubmit="enviarLogin()">
                @csrf
                <div class="row mt-6">
                    <div class="col-sm">
                        <fieldset class="border-solid-sm rounder-md p-4">
                            <legend class="text-up-02">Login Participante</legend>
                            <div class="row  justify-content-center">
                                <div class="col-md-12">
                                    <div class="br-input"><label for="cpf">CPF</label>
                                        <input type="hidden" id="evento_id" name="evento_id" value="
                                        @if($parametro == 0)
                                            0
                                        @else
                                            {{ $evento->first()->id }}
                                        @endif
                                        ">
                                        <input id="cpf" name="cpf" onkeyup="mascara_cpf()" maxlength="14" placeholder="Digite seu CPF" type="text" @isset($cpf) value="{{$cpf}}" readonly @endisset/>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="br-input"><label for="senha">Senha</label>
                                        <input id="senha" name="senha" type="password" placeholder="Digite sua senha" />
                                    </div>
                                </div>
                            </div>
                            @if($exists == true)
                                <div class="br-textarea danger text-center">
                                    <span class="feedback success" role="alert"><i class="fas fa-check-circle fa-lg" aria-hidden="true"></i><span>Identificamos que você é funcionário(a) do HFA, use sua senha de rede para efetuar o login!</span></span>
                                </div>
                                <br>
                                <div class="br-textarea text-center">
                                    <span>Para redefinir sua senha entre em contato com a DTI!</span>
                                </div>
                            @else
                                @if(isset($cpf))
                                <div class="text-right">
                                    <a href="{{route('redefinirSenha.index', $cpf )}}">Esqueceu a Senha?</a>
                                </div>
                                <br>
                                @endif
                            @endif
                            
                            @if (session('erro'))

                            <div class="br-textarea danger text-center">
                                <span class="feedback danger" role="alert"><i class="fas fa-times-circle" aria-hidden="true"></i><span>{{ session('erro') }}</span></span>
                            </div>

                            @endif
                            <div class="row justify-content-center mt-4">
                                <button type="submit" class="br-button primary mr-3" id="enviarLog">Login</button>
                            </div>
                        </fieldset>

                    </div>

                </div>
            </form>
           
            <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer>
            </script>
        </div>

    </div>

</body>

@include('site.cadastro.js')
@include('site.site-layout.footer')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>


</html>