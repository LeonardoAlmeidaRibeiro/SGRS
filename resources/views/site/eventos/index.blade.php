@include('site.site-layout.header')
<script src="{{ url('assets/ckeditor/build/ckeditor.js') }}"></script>

<div class="container-lg mt-4">
   <div class="br-breadcrumb">
      <ul class="crumb-list">
         <li class="crumb home"><a class="br-button circle" href="{{ route('site.index')}}">
               <span class="sr-only">Página inicial</span><i class="fas fa-home"></i></a>
         </li>
         <li class="crumb" data-active="active"><i class="icon fas fa-chevron-right"></i><a href="{{ route('evento.index', $evento->id)}}">Evento</a>
         </li>
      </ul>
   </div>
</div>

<div style="background-color: #F3F3F3;" class="container-fluid">
   <div class="container-lg mb-6">
      <h2 class="text-center text-weight-semi-bold  mt-5 pt-3">{{$evento->nome_evento}}</h2>
   </div>
</div>

<div class="container-lg mb-6 mt-4">
   <div class="pl-sm-3 ">
      <div class="row mt-5">
         <div class="col-sm-6 col-md-4 col-lg-6 ">
            <div class="br-card">
               <div class="card-content">
                  @if($evento->imagem != null)
                  <img src="{{ asset('storage/'.$evento->imagem) }}" width="100%" alt="Imagem do evento" />
                  @else
                  <img src="{{ url('assets/imagens/SemImagem.png') }}" width="100%" alt="Sem Imagem " />
                  @endif
               </div>
            </div>
         </div>
         <div class="d-flex flex-column pb-3 col-lg-6 ">
            <div class="text-up-01 mb-2">
               <span class="text-weight-semi-bold">Data:</span>
               <span>{{date('d/m/y', strtotime($evento->data_evento ))}}</span>
            </div>
            <div class="text-up-01 mb-2">
               <span class="text-weight-semi-bold">Email: </span>
               <span>{{$evento->email}}</span>
            </div>
            <div class="text-up-01 mb-2">
               <span class="text-weight-semi-bold">Carga Horária: </span>
               <span>{{$evento->carga_horaria}}</span>
            </div>
            <div class="text-up-01 mb-2">
               <span class="text-weight-semi-bold">Local: </span>
               <span>{{$evento->unidadeEvento()->first()->nome}}</span>
            </div>
            <div class="text-up-01 mb-2">
               <span class="text-weight-semi-bold">Vagas: </span>
               <span>{{$evento->vaga_evento}}</span>
            </div>
            <div class="text-up-01 mb-2">
               <span class="text-weight-semi-bold">Vagas Restantes: </span>
               <span>@if($qtd_vagas<=0) 0 @else {{$qtd_vagas}} @endif</span>
            </div>
            <div class="text-up-01 mb-2">
               <span class="text-weight-semi-bold">Inscritos até o momento: </span>
               <span>@if($qtd_vagas<=0) {{$evento->vaga_evento}} @else {{$inscritos}} @endif</span>
            </div>
            <div class="text-up-01 mb-2">
               <span class="text-weight-semi-bold">Público:</span>
               <span>{{preg_replace('/,/', ', ', $evento->publico_alvo)}}</span>
            </div>
            <div class="text-up-01">
               <span class="text-weight-semi-bold">Descrição:</span>
               <span class="ck-editor"> <?php echo $evento->descricao ?></span>
            </div><br><br>

            <div class="text-up-01">
               <div class="p-3">
                  @if($evento->status_evento == 'S')
                  @if($qtd_vagas > 0 )
                  <a id="enviarInscr" class="br-button primary" @if(session()->get('nome') != '') onclick="inscrever({{$evento->id}})"@else onclick="botaoInscricao()" href="{{ route('cadastro.index',$evento->id) }}" @endif >
                     Inscrição
                  </a>
                  @endif
                  @endif
                  @if($evento->arq_programacao != null)
                  <button class="br-button secondary mr-3" type="button"> <a href="{{ url('storage/'.$evento->arq_programacao) }}" target="_blank"> Programação do Evento </a></button>
                  @endif
               </div>
            </div>


         </div>
      </div>
   </div>
</div>
@if($evento->video != null)
<div style="background-color: #F3F3F3;" class="container-fluid mb-6">
   <div class="container-lg mb-6">
      <h2 class="text-center text-weight-semi-bold  mt-5 pt-3">Videos</h2>
   </div>
</div>
<div class="container-lg mb-6">
   <div class="pl-sm-3 ">
      <div class="embed-responsive embed-responsive-16by9 text-center">
         <iframe width="700" height="450" src="
               @php
                  $codigo = explode('?v=', $evento->video);
                  if(isset($codigo[1]))
                     $link = 'https://www.youtube.com/embed/' . $codigo[1];
                  else 
                     $link  = $evento->video
               @endphp
               {{ $link}}
               " title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
      </div>
   </div>
</div>
@endif

<div style="background-color: #F3F3F3;" class="container-fluid mb-6">
   <div class="container-lg mb-6">
      <h2 class="text-center text-weight-semi-bold  mt-5 pt-3">Programação do Evento</h2>
   </div>
</div>
@if ($evento->arq_programacao == null )
@if(sizeof($programacaoDia)>0 and sizeof($horarios)>0)
<div class="container-lg mb-6">
   <div class="pl-sm-3 ">
      <div class="br-tab">
         <nav class="tab-nav">
            <ul>
               @foreach($programacaoDia as $progDia)
               <li class="tab-item text-weight-semi-bold align-items @if($progDia->id == $programacaoDia->first()->id) active @endif">
                  <button type="button" data-panel="horarios_{{$progDia->id}}">{{date( 'd/m/y', strtotime($progDia->dia))}}</button>
               </li>
               @endforeach
            </ul>
         </nav>
         @foreach($horarios as $progHora)
         <div class="tab-content">
            <div class="d-flex border-solid-sm border-gray-5">
               <div class="col-lg-1 m-3 tab-panel @if($progHora['progDia_id'] == $programacaoDia->first()->id) active @endif" id="horarios_{{$progHora['progDia_id']}}">
                  <div class="text-up-02">{{$progHora['hora']}}</div>
               </div>
               <div class="tab-panel m-3 @if($progHora['progDia_id'] == $programacaoDia->first()->id) active @endif" id="horarios_{{$progHora['progDia_id']}}">
                  <div class="text-up-02">{{$progHora['descricao']}}</div>
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </div>
</div>
@else
<div class="container-lg mb-6 pb-6 mt-6">
   <div class="pl-sm-3" align="center">
      <span class="text-up-03">Nenhuma Programação Agendada</span>
   </div>
</div>
@endif
@else
<div class="container-lg mb-6 pb-6 mt-6">
   <div class="pl-sm-3" align="center">
      <span class="text-up-03">Baixe a programação do Evento</span>
      <div class="p-3">
         <button class="br-button secondary mr-3" type="button"> <a href="{{ url('storage/'.$evento->arq_programacao) }}" target="_blank"> Programação do Evento </a></button>
      </div>
   </div>
</div>
@endif

<script>
   const abasList = []
   for (const brTab of window.document.querySelectorAll('.br-tab')) {
      abasList.push(new core.BRTab('br-tab', brTab))
   }

   function botaoInscricao() {
      $("#enviarInscr").html('Aguarde...');
      $('#enviarInscr').prop('disabled', true); //Desabilita o botão
   }
</script>

@include('site.site-layout.footer')
@include('site.participante.js')