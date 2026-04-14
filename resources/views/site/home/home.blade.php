@include('site.site-layout.header')
   <div class="container-lg mt-4">
      <div class="br-breadcrumb">
         <ul class="crumb-list">
            <li class="crumb home"><a class="br-button circle" href="{{ route('site.index')}}">
                  <span class="sr-only">Página inicial</span><i class="fas fa-home"></i></a>
            </li>
            <li class="crumb" data-active="active"><i class="icon fas fa-chevron-right"></i><a href="{{ route('site.index')}}">Home</a>
            </li>
         </ul>
      </div>
   </div>

   <div class="br-tab">
      <nav class="tab-nav container-fluid" style="background-color: #F3F3F3;">
         <div >
            <div class="container-lg mb-5 pb-3">
               <h2 class="text-center text-weight-semi-bold  mt-5 pt-3">Nossos Eventos</h2>
               <div class="d-flex flex-row justify-content-center col-lg-12">
                  
                  <div class="tab-item col-md-3 @if(isset(request()->evento))@if(request()->evento != 'encerrados')active @endif @else active @endif">
                     <button class="br-card col-lg-12 mr-5 mt-3 text-center" style="background-color: white;" data-panel="eventos" >
                        <div class="card-content">
                           <span class="text-up-02">Todos</span>
                        </div>
                     </button>
                  </div>
                  @foreach($cat_eventos as $categoria)
                     <div class="tab-item col-md-3">
                        <button class="br-card col-lg-12 mr-5 mt-3 text-center" style="background-color: white;" data-panel="eventos_{{$categoria->categoria_id}}">
                           <div class="card-content">
                              <span class="text-up-02">{{ucfirst(mb_strtolower($categoria->nome_categoria))}}</span>
                           </div>
                        </button>
                     </div>
                  @endforeach

                  <div class="tab-item col-md-3 @if(isset(request()->evento))@if(request()->evento == 'encerrados')active @endif @endif">
                     <button class="br-card col-lg-12 mr-5 mt-3 text-center" style="background-color: white;" data-panel="evento_encerrados">
                        <div class="card-content">
                           <span class="text-up-02">Encerrados</span>
                        </div>
                     </button>
                  </div>
               </div>
            </div>
         </div>
      </nav>

         <div class="tab-content container-lg mb-6 mt-6">

            <div  class="tab-panel @if(isset(request()->evento))@if(request()->evento != 'encerrados')active @endif @else active @endif" id="eventos">
               @if(count($eventos) > 0)
                  <h2 class="text-center text-weight-semi-bold mt-6 pt-3">Inscrições Abertas</h2>
                  <div class="pl-sm-3 ">
                     <div class="row mt-5">
                        @foreach($eventos as $evento)
                           
                              @if($evento->status_evento == "S")
                                 <div class="col-sm-6 col-md-4 col-lg-3 ">
                                    <div class="br-card mb-6">

                                       <div class="card-content">
                                          @if($evento->imagem != null)
                                          <a href="{{route('evento.index', $evento->id)}}">
                                             <img src="{{ asset('storage/'.$evento->imagem) }}" width="100%" alt="Imagem do evento" />
                                          </a>
                                          @else
                                          <img src="{{ url('assets/imagens/SemImagem.png') }}" width="100%" alt="Sem Imagem " />
                                          @endif
                                       </div>
                                       <div class="car-footer pb-3">
                                          <div class="col-lg-12 d-flex flex-column pb-3">
                                             <a href="{{route('evento.index', $evento->id)}}" style="color: black;">
                                                <div class="text-weight-semi-bold text-up-02 text-wrap">{{$evento->nome_evento}}</div>
                                             </a>
                                             <div class="br-divider mt-3 mb-3 bg-gray-1"></div>
                                             <div class="text-up-01">
                                                <span class="text-weight-semi-bold">Data:</span>
                                                <span>{{date('d/m/y', strtotime($evento->data_evento ))}}</span>
                                             </div>
                                             <div>
                                                <span class="text-weight-semi-bold">Vagas: </span>
                                                <span>{{$evento->vaga_evento}}</span>
                                             </div>
                                             <div>
                                                <span class="text-weight-semi-bold">Público:</span>
                                                <span>{{preg_replace('/,/', ', ', $evento->publico_alvo)}}</span>
                                             </div>
                                          </div>
                                          
                                          <div>
                                             <div class="text-right mr-3">
                                                <a class="br-button primary" href="{{route('evento.index', $evento->id)}}" >
                                                   + Detalhes
                                                </a>
                                             </div>
                                       
                                          </div> 
                                       </div>
                                    </div>
                                 </div>
                              @endif
                           @endforeach
                           
                     </div>
                  </div>
               @else
                  <h2 class="text-center text-weight-semi-bold mt-6 pt-3">Nenhum Evento em aberto</h2>
               @endif
            </div>
           
            @foreach($cat_eventos as $cat_evento)

               <div  class="tab-panel" id="eventos_{{$cat_evento->categoria_id}}">
                  <h2 class="text-center text-weight-semi-bold mt-6 pt-3">Inscrições Abertas</h2>
                  <div class="pl-sm-3 ">
                     <div class="row mt-5">
                     @foreach($eventos as $evento)
                        @if($evento->categoria_evento_id == $cat_evento->categoria_id)
                           @if($evento->status_evento == "S")
                           <div class="col-sm-6 col-md-4 col-lg-3 ">
                              <div class="br-card mb-6">

                                 <div class="card-content">
                                    @if($evento->imagem != null)
                                    <a href="{{route('evento.index', $evento->id)}}">
                                       <img src="{{ asset('storage/'.$evento->imagem) }}" width="100%" alt="Imagem do evento" />
                                    </a>
                                    @else
                                    <img src="{{ url('assets/imagens/SemImagem.png') }}" width="100%" alt="Sem Imagem " />
                                    @endif
                                 </div>
                                 <div class="car-footer pb-3">
                                    <div class="col-lg-12 d-flex flex-column pb-3">
                                       <div class="text-weight-semi-bold text-up-02 text-wrap">{{$evento->nome_evento}}</div>
                                       <div class="br-divider mt-3  mb-3"></div>
                                       <div class="text-up-01">
                                          <span class="text-weight-semi-bold">Data:</span>
                                          <span>{{date('d/m/y', strtotime($evento->data_evento ))}}</span>
                                       </div>
                                       <div>
                                          <span class="text-weight-semi-bold">Vagas: </span>
                                          <span>{{$evento->vaga_evento}}</span>
                                       </div>
                                       <div>
                                          <span class="text-weight-semi-bold">Público:</span>
                                          <span>{{preg_replace('/,/', ', ', $evento->publico_alvo)}}</span>
                                       </div>
                                    </div>
                                    <div>
                                       <div class="text-right mr-3">
                                          <a class="br-button primary" href="{{route('evento.index', $evento->id)}}">
                                             + Detalhes
                                          </a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           @endif
                        @endif
                     @endforeach
                     </div>
                  </div>
               </div>
            @endforeach
            
            <div class="tab-panel @if(isset(request()->evento))@if(request()->evento == 'encerrados')active @endif @endif" id="evento_encerrados">
               <h2 class="text-center text-weight-semi-bold mt-6 pt-3">Eventos Encerrados</h2>
               <div class="pl-sm-3">
                  <div class="row mt-5">
                     @foreach($eventosEncerrados as $evento)
                     @if($evento->status_evento == "N")
                        <div class="col-sm-6 col-md-4 col-lg-3 ">
                           <div class="br-card mb-6">

                              <div class="card-content">
                                 @if($evento->imagem != null)
                                 <a href="{{route('evento.index', $evento->id)}}">
                                    <img src="{{ asset('storage/'.$evento->imagem) }}" width="100%" alt="Imagem do evento" />
                                 </a>
                                 @else
                                 <img src="{{ url('assets/imagens/SemImagem.png') }}" width="100%" alt="Sem Imagem " />
                                 @endif
                              </div>
                              <div class="car-footer pb-3">
                                 <div class="col-lg-12 d-flex flex-column pb-3">
                                    <div class="text-weight-semi-bold text-up-02 text-wrap">{{$evento->nome_evento}}</div>
                                    <div class="br-divider mt-3  mb-3"></div>
                                    <div class="text-up-01">
                                       <span class="text-weight-semi-bold">Data:</span>
                                       <span>{{date('d/m/y', strtotime($evento->data_evento ))}}</span>
                                    </div>
                                    <div>
                                       <span class="text-weight-semi-bold">Vagas: </span>
                                       <span>{{$evento->vaga_evento}}</span>
                                    </div>
                                    <div>
                                       <span class="text-weight-semi-bold">Público:</span>
                                       <span>{{preg_replace('/,/', ', ', $evento->publico_alvo)}}</span>
                                    </div>
                                 </div>
                                 <div>
                                    <div class="text-right mr-3">
                                          <a class="br-button primary" href="{{route('evento.index', $evento->id)}}">
                                             + Detalhes
                                          </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     @endif
                     @endforeach
                     
                  </div>

               </div>
               
               <div class="br-pagination" >
                  <ul>
                     
                     @if($eventosEncerrados->currentPage() != '1')
                        <li>
                           <a class="br-button circle" href="{{$eventosEncerrados->previousPageUrl()}}"><i class="fas fa-angle-left" aria-hidden="true"></i></a>
                        </li>
                     @endif

                        @foreach($eventosEncerrados->render()['elements'] as $elementos)
                           @if($elementos == '...')
                              <li>
                                 <a class="page disable">...</a>
                              </li>
                           @else
                              @foreach($elementos as $key=>$elemento)
                                 <li>
                                    <a class="page @if($eventosEncerrados->currentPage() == $key) active @endif" href="{{$elemento}}&evento=encerrados">{{$key}}</a>
                                 </li>
                              @endforeach
                           @endif
                        @endforeach

                     @if($eventosEncerrados->currentPage() != $eventosEncerrados->lastPage())
                        <li>
                           <a class="br-button circle" href="{{$eventosEncerrados->nextPageUrl()}}&evento=encerrados">
                              <i class="fas fa-angle-right" aria-hidden="true"></i>
                           </a>
                        </li>
                     @endif

                  </ul>
               </div>

            </div>
         </div>
   </div>
<script>

   const abasList = []
   for (const brTab of window.document.querySelectorAll('.br-tab')) {
      abasList.push(new core.BRTab('br-tab', brTab))
   }
   
</script>

@include('site.site-layout.footer')
