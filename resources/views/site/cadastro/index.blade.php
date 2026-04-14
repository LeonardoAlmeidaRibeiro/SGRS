@include('site.site-layout.header')




<div class="container-lg mt-4">
    <div class="br-breadcrumb">
        <ul class="crumb-list">
            <li class="crumb home"><a class="br-button circle" href="{{ route('site.index')}}">
                    <span class="sr-only">Página inicial</span><i class="fas fa-home"></i></a>
            </li>
            <li class="crumb" data-active="active"><i class="icon fas fa-chevron-right"></i><a href="{{ route('cadastro.index',0)}}">Área do Participante</a>
            </li>
        </ul>
    </div>
</div>
@if($parametro == 0)
<div class="container-fluid" style="background-color: #F3F3F3;">
    <h2 class="text-center">Área do Participante</h2>
    <div class="container-lg text-center">
        <span class="text-up-01">
            <br>
            Aqui você encontrará os certificados de participação nos eventos que voce se inscreveu além de todos os arquivos referentes a cada evento.
        </span><br><br><br>
    </div>
</div>
@else
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

<div class="container-lg" style="width: 75%;">
    <!-- Content here -->
    

        @if($qtd_vagas<=0)
            <div class="form-group p-5" style="width: 80%; margin-left: auto; margin-right: auto;">
                <br>
                <div class="container-lg text-center">
                    <span class="text-up-03">
                        <font color="red"><strong>
                            Prezado(a) usuário(a),<br><br>
                            Lamentamos informar que as vagas para o evento já foram preenchidas e não é mais possível fazer inscrição.
                        </strong></font>
                    </span>
                </div>
            </div>
        @else
            <div class="form-group p-5" style="width: 40%; margin-left: auto; margin-right: auto;">
                <form action="@if($parametro == 0) {{ route('cadastroParticipante.index.site',0) }} @else {{ route('cadastroParticipante.index.site',$evento->first()->id) }} @endif" method="GET">
                    @csrf
                    <div class="row mt-6">
                        <div class="col-sm">
                            <fieldset class="border-solid-sm rounder-md p-4">
                                <legend class="text-up-02"></legend>
                                <div class="row  justify-content-center">
                                    <div class="col-md-9 mb-2">
                                        <div class="br-input"><label for="name">CPF</label>
                                            <input id="cpf" name="cpf" placeholder="Digite seu CPF" type="text" maxlength="14" onkeyup="mascara_cpf();" />
                                        </div>

                                    
                                        @if ($msg_alt_senha)
                                            <div class="justify-content-center feedback success mt-2" role="alert">
                                                <i class="fas fa-times-circle" aria-hidden="true"></i><span>{{$msg_alt_senha}}</span></span>
                                            </div>
                                        @endif 

                                        
                                        <div class="row justify-content-center mt-4">
                                            <button type="submit" class="br-button primary mr-3">Continuar
                                                {{-- <i aria-hidden class="fas fa-plus"></i> --}}
                                            </button>
                                        </div>
                                    </div>
                            </fieldset>

                        </div>

                    </div>
                </form>
            </div>
        @endif

    

</div>


</div>

</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@include('site.cadastro.js')
@include('site.site-layout.footer')

</html>