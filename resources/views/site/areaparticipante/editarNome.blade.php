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
<br><br><br>
    <h2 class="text-center">Alterar Nome no Certificado</h2>
    <div class="container-lg text-center">
        <span class="text-up-02">
            
        </span><br><br><br>
    </div>
</div>


@php
$i=0;
@endphp
<div class="container-lg" style="width: 35%;">
    <!-- Content here -->
   
    <div class="form-group p-5">
        @csrf
        <form action="#">
           
            <div class="row mt-6">
                <div class="col-sm">
                    <fieldset class="border-solid-sm rounder-md p-4">
                        <legend class="text-up-02">Alterar Nome</legend>

                            <input type="hidden" id="id" name="id" value="{{$inscricao->first()->id}}">
                            <input type="hidden" id="evento_id" name="evento_id" value="{{$evento->first()->id}}">
                            <input type="hidden" id="tipo_certificado" name="tipo_certificado" value="{{$tipo_certificado}}">
                            <input type="hidden" id="participante_id" name="participante_id" value="{{$participante->first()->id}}">
                            <div class="col-lg-12" align="center">
                                <div class="br-input"><label for="nome">Nome</label>
                                    <input id="nomeParticipante" name="nomeParticipante" type="name" value="{{ $participante->first()->nome }}" />
                                </div>
                            </div>

                       
                        <br>

                  
                        <br><br>

                        <div align="center">
                            <button class="br-button primary mr-3" id="enviarInscr" type="button" onclick="return editarNome()">Enviar</button>
                        </div>

                    </fieldset>
                </div>
            </div>

        </form>
    </div>
</div>





<link rel="stylesheet" href="../assets/node_modules/@govbr-ds/core/dist/core.css" />
<script src="../assets/node_modules/@govbr-ds/core/dist/core.js"></script>

@include('site.participante.js')



@include('site.contato.js')

@include('site.site-layout.footer')