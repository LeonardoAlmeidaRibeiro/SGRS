@include('site.site-layout.header')

<div class="container-lg mt-4">
   <div class="br-breadcrumb">
   <ul class="crumb-list">
      <li class="crumb home"><a class="br-button circle" href="{{ route('site.index')}}">
         <span class="sr-only">Página inicial</span><i class="fas fa-home"></i></a>
      </li>
      <li class="crumb" data-active="active"><i class="icon fas fa-chevron-right"></i><span>Página Fale Conosco</span>
      </li>
   </ul>
   </div>
</div>
<div class="container-fluid" style="background-color: #F3F3F3;">
    <h2 class="text-center">{{$evento->first()->nome_evento}}</h2>
    <div class="container-lg text-center">
        <span class="text-up-02">
            Data do evento:&nbsp;{{date('d/m/Y', strtotime($evento->first()->data_evento))}} <br>
            Local:&nbsp;{{$evento->first()->unidadeEvento->first()->nome}}
        </span><br><br><br>
    </div>
</div>
<div class="container-lg" style="width: 30%;">
    <!-- Content here -->
    <div class="form-group p-4">
        <form method="get" action="{{ route('cadastroParticipante.index.site',$evento->first()->id) }}">

            <div class="row mt-6">
                <div class="col-sm">
                    <fieldset class="border-solid-sm rounder-md p-4">
                        <legend class="text-up-02">Realizar Inscrição</legend>
                        <div class="row  justify-content-center">
                            <div class="col-md-12 mb-2">
                                <div class="br-input"><label for="name">CPF</label>
                                    <input id="cpf" name="cpf" placeholder="Digite seu CPF" type="text" maxlength="14" onkeyup="mascara_cpf();"/>
                                </div>
                            </div>
                           
                        <div class="row justify-content-center mt-4">
                            <button type="submit" class="br-button primary mr-3">Continuar
                                {{-- <i aria-hidden class="fas fa-plus"></i> --}}
                            </button>
                        </div>
                    </fieldset>
                    
                </div>
   
            </div>
        </form>
    </div>



</div>

<link rel="stylesheet" href="assets/node_modules/@govbr-ds/core/dist/core.css" />
<script src="assets/node_modules/@govbr-ds/core/dist/core.js"></script>

@include('site.participante.js')
@include('site.contato.js')


@include('site.site-layout.footer')

