@include('site.site-layout.header')

<div class="container-lg mt-4">
    <div class="br-breadcrumb">
        <ul class="crumb-list">
            <li class="crumb home"><a class="br-button circle" href="{{ route('site.index')}}">
                    <span class="sr-only">Página inicial</span><i class="fas fa-home"></i></a>
            </li>
            <li class="crumb" data-active="active"><i class="icon fas fa-chevron-right"></i><a href="{{ route('participante.areaParticipante')}}">Enviar Email</a>
            </li>
        </ul>
    </div>
</div>

<body>

    <div class="container-sm">
        <!-- Content here -->
        <div class="form-group p-5" style="width: 30%; margin-left: auto; margin-right: auto;">

            <form class="form" action="{{ route('enviarEmail.email') }}" method="post">
                @csrf
                <div class="row mt-6">
                    <div class="col-sm">
                        <fieldset class="border-solid-sm rounder-md p-4">
                            <legend class="text-up-02">Enviar Email</legend>
                            <div class="row  justify-content-center">
                                <div class="col-md-12">
                                    <div class="br-input"><label for="cpf">CPF</label>
                                        <input id="cpf" name="cpf" type="hidden" value="{{$cpf}}"/>
                                        <input id="email" name="email" type="hidden" value="{{$email}}"/>
                                        <input type="text" value="{{$cpf}}" disabled/>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12 mb-2">
                                <div class="g-recaptcha" data-sitekey="6Ld4LCYlAAAAAIE3_kLZ8qrBpdZZoueOophPmVJe"></div>
                            </div>
                        
                            @if (Session::has('g-recaptcha-response'))
                            <div class="br-textarea danger text-center">
                                <span class="feedback danger" role="alert"><i class="fas fa-times-circle" aria-hidden="true"></i><span>{{ session('g-recaptcha-response') }}</span></span>
                            </div>
                            @endif
                           
                            @if (session('success'))
                                <div class="feedback success" role="alert">
                                    </i><span>{{ session('success') }}</span></span>
                                </div>
                            @endif 
                                
                            <div class="row justify-content-center mt-4">
                                <button type="submit" class="br-button primary mr-3" id="enviarLog">Enviar</button>
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