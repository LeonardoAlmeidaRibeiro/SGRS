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

<div class="container-fluid" style="background-color: #F3F3F3;">
    <h2 class="text-center">Arquivos do Evento</h2>
    <div class="container-lg text-center">
        <span class="text-up-01">
            <p style="text-align: center;">Aqui você encontrará todos os arquivos disponíveis para o evento.</p>
        </span>
        <br>
    </div>
</div>

<div class="container-sm">
    <br>
    <div class="container-fluid">
        <h2 class="text-center">Evento {{$evento->first()->nome_evento}}</h2>
    </div>

</div>

<div class="container-sm">

    <div class="br-table" data-search="data-search" data-selection="data-selection" data-collapse="data-collapse" data-random="data-random">
        <div class="table-header">
            <div class="top-bar">
            </div>
        </div>
        @if(count($documento)>0 )
        <table>
            <thead>
                <tr class="border-right border-bottom border-left border-top">
                    <th class="column-collapse" scope="col"></th>
                    <th scope="col"> <label for="select-simple">Arquivos</label></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documento as $documentos)

                <tr class="border-right border-bottom border-left border-top">
                    <td>
                        <div class="br-checkbox hidden-label">
                            <a href="{{ url('storage/'.$documentos->arquivo_documento) }}" target="_blank" style="color: currentColor;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                </svg></a>
                        </div>
                    </td>
                    <td>
                        <a href="{{ url('storage/'.$documentos->arquivo_documento) }}" target="_blank" style="color: currentColor;"> {{$documentos->nome_documento}} </a>
                    </td>
                    <td></td>
                    <td class="collapse">

                   
                      <td style="text-align: Right;">
                            <a href="{{ url('storage/'.$documentos->arquivo_documento) }}" target="_blank"> <button class="br-button primary mr-3" type="button">Download</button>
                        </a>
                    </td>
                    

                </tr>
                <tr class="collapse">
                    <td id="collapse-1-4-66325" aria-hidden="true" hidden="hidden" colspan="6">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies aliquet lacinia. Vestibulum in interdum eros. Donec vel tempus diam. Aenean pulvinar mattis nisi in laoreet. Integer felis mi, vehicula sed pretium sit amet, pellentesque vel nisl. Curabitur metus ante, pellentesque in lectus a, sagittis imperdiet mi.</td>
                </tr>
                <tr class="collapse">
                    <td id="collapse-2-4-66325" aria-hidden="true" hidden="hidden" colspan="6">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultricies aliquet lacinia. Vestibulum in interdum eros. Donec vel tempus diam. Aenean pulvinar mattis nisi in laoreet. Integer felis mi, vehicula sed pretium sit amet, pellentesque vel nisl. Curabitur metus ante, pellentesque in lectus a, sagittis imperdiet mi.</td>
                </tr>
                

                @endforeach
                @else
                <table>
                    <thead>
                        <tr class="border-right border-bottom border-left border-top">
                            <th class="column-collapse" scope="col">Arquivos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-right border-bottom border-left border-top">
                            <td style="text-align: center;">
                                Nenhum arquivo disponível para download nesse evento
                            </td>
                        </tr>
                        @endif
                    </tbody>

                </table>
    </div>

</div>

<br>
<div class="container-sm">
    <div class="text-right">
    <a href="{{ route('participante.areaParticipante')}}" class="br-button primary mr-3" type="button">Voltar </a>
    </div>
</div>
<br>
<br><br><br>

@include('site.cadastro.js')
@include('site.site-layout.footer')


</html>