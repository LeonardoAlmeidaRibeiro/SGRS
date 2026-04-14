@include('site.site-layout.header')
    <div class="container-lg mt-4">
        <div class="br-breadcrumb">
            <ul class="crumb-list">
                <li class="crumb home"><a class="br-button circle" href="{{ route('site.index')}}">
                    <span class="sr-only">Página inicial</span><i class="fas fa-home"></i></a>
                </li>
                <li class="crumb" data-active="active"><i class="icon fas fa-chevron-right"></i><span>Busca</span>
                </li>
            </ul>
        </div>
        <div class="br-divider"></div>
    </div>

    <div class="container-lg mb-6">

        <h4 class="text-blue-warm-vivid-70">&ldquo;@if(isset(request()->pesquisa)) {{request()->pesquisa}} @else {{$busca}} @endif&rdquo;</h4>

        @if(count($eventos) > 0)
            
            <div>
                <ul class="mt-3">
                    @foreach($eventos as $evento)
                        <li>
                            <a href="{{route('evento.index', $evento->id)}}">
                            <span class="text-up-02 text-blue-warm-vivid-50 m-0">{{$evento->nome_evento}}</span>
                            <p>{{date( 'd/m/y', strtotime($evento->data_evento))}}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="br-pagination">
                <ul>

                    @if($eventos->currentPage() != '1')
                        <li>
                            <a class="br-button circle" href="{{$eventos->previousPageUrl()}}"><i class="fas fa-angle-left" aria-hidden="true"></i></a>
                        </li>
                    @endif

                    @foreach($eventos->render()['elements'] as $paginas)
                        @if($paginas == '...')
                            <li>
                                <a class="page disable">...</a>
                            </li>
                        @else
                            @foreach($paginas as $key=>$pagina)
                                <li>
                                    <a class="page @if($eventos->currentPage() == $key) active @endif" href="{{$pagina}}&pesquisa={{$busca}}">{{$key}}</a>
                                </li>
                            @endforeach
                        @endif

                    @endforeach
                    
                    @if($eventos->currentPage() != $eventos->lastPage())
                        <li>
                            <a class="br-button circle" href="{{$eventos->nextPageUrl()}}">
                                <i class="fas fa-angle-right" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        @else
            <div class="text-center text-up-03">
                <span>Nenhum resultado encontrado para: &ldquo;{{$busca}}&rdquo;.</span>
            </div>
        @endif
    </div>
    

@include('site.site-layout.footer')
