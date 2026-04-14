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
    <h2 class="text-center">Certificados</h2>
    <div class="container-lg text-center">
        <span class="text-up-01">
            <p style="text-align: center;">Aqui você encontrará os certificados de participação.</p>
        </span>
        <br>
    </div>
</div>

<div class="container-sm">
    <br>
    <div class="container-fluid">
        <input type="hidden" id="evento_id" value="{{$evento->id}}">
        <h2 class="text-center">Evento {{$evento->nome_evento}}</h2>
    </div>

</div>

<div class="container-sm">

    <div class="br-table" data-search="data-search" data-selection="data-selection" data-collapse="data-collapse" data-random="data-random">
        <div class="table-header">
            <div class="top-bar">
            </div>
        </div>

        <table>
            <thead>
                <tr class="border-right border-bottom border-left border-top">
                    <th class="column-collapse" scope="col"></th>
                    <th scope="col"> <label for="select-simple">Certificados</label></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <div align="right">
                <a href="{{ route('participante.alterarNome.index',$inscricao->first()->id) }}" class="br-button primary mr-3" type="button">Alterar Nome no Certificado
                </a>
            </div><br>
            <tbody>

                
                @foreach ($inscricao as $inscricaos)
                    @if($inscricaos->presenca == 'S' )
                        @if ($inscricaos->participante == 'S')
                        <tr class="border-right border-bottom border-left border-top">
                            <td>
                                <div class="br-checkbox hidden-label">
                                    <a href="#" style="color: currentColor;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                                        </svg></a>
                                </div>
                            </td>
                            <td>
                                <a href="#" style="color: currentColor;">Certificado de Participante</a>
                            </td>
                            <td></td>
                            <td style="text-align: Right;">
                            <button class="br-button primary mr-3" onclick="exportarPdf('Participante','{{$inscricaos->id}}')" type="button">Download</button>
                            </td>
                        </tr>
                        @endif

                        @if ($inscricaos->ouvinte == 'S')
                        <tr class="border-right border-bottom border-left border-top">
                            <td>
                                <div class="br-checkbox hidden-label">
                                    <a href="#" style="color: currentColor;"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                                        </svg></a>
                                </div>
                            </td>
                            <td>
                                <a href="#" style="color: currentColor;"> Certificado de Ouvinte</a>
                            </td>
                            <td></td>
                            <td style="text-align: Right;">
                                <button class="br-button primary mr-3" onclick="exportarPdf('Ouvinte','{{$inscricaos->id}}')" type="button">Download</button>
                            </td>
                        </tr>
                        @endif

                        @if ($inscricaos->palestrante == 'S')
                        <tr class="border-right border-bottom border-left border-top">
                            <td>
                                <div class="br-checkbox hidden-label">
                                    <a href="#" style="color: currentColor;"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                                        </svg></a>
                                </div>
                            </td>
                            <td>
                                <a href="#" style="color: currentColor;"> Certificado de Palestrante</a>
                            </td>
                            <td></td>
                            <td style="text-align: Right;">
                                <button class="br-button primary mr-3" onclick="exportarPdf('Palestrante','{{$inscricaos->id}}')" type="button">Download</button>
                            </td>
                        </tr>
                        @endif

                        @if ($inscricaos->org_evento == 'S')
                        <tr class="border-right border-bottom border-left border-top">
                            <td>
                                <div class="br-checkbox hidden-label">
                                    <a href="#" style="color: currentColor;"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
                                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5ZM9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8Zm1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5Zm-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96c.026-.163.04-.33.04-.5ZM7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                                        </svg></a>
                                </div>
                            </td>
                            <td>
                                <a href="#" style="color: currentColor;"> Certificado de Organizador do Evento</a>
                            </td>
                            <td></td>
                            <td style="text-align: Right;">
                                <button class="br-button primary mr-3" onclick="exportarPdf('Organizador do Evento','{{$inscricaos->id}}')" type="button">Download</button>
                            </td>
                            
                        </tr>
                        @endif
                    @else
                        <tr class="border-right border-bottom border-left border-top">
                            <td style="text-align: center;" colspan="4">
                            Nenhum certificado disponível para download nesse momento.
                            </td>
                        </tr>
                    @endif

                @endforeach
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
@include('site.areaparticipante.js')
@include('site.site-layout.footer')

</html>