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
@else
<div class="container-fluid" style="background-color: #F3F3F3;">
    <h2 class="text-center">Área do Participante</h2>
    <div class="container-lg text-center">
        <span class="text-up-01">
            <br>
            Aqui você encontrará os certificados de participação nos eventos que voce se inscreveu além de todos os arquivos referentes a cada evento.
        </span><br><br><br>
    </div>
</div>
@endif
@php
$i=0;
@endphp
<div class="container-lg">
    <!-- Content here -->
    <input id="evento_id" type="hidden" value="@if($parametro != 0){{ $evento->first()->id }}@endif" />
    <div class="form-group p-5">
        @csrf
        <form action="#">
            <input id="parametro" name="parametro" type="hidden" value="{{ $parametro }}" />
            <input id="existe" name="existe" type="hidden" value="{{ $exists }}" />
            <div class="row mt-6">
                <div class="col-sm">
                    <fieldset class="border-solid-sm rounder-md p-4">
                        <legend class="text-up-02">Realizar @if($parametro == 0) Cadastro @else Inscrição @endif</legend>

                        <div class="form-group row">

                            <div class="col-lg-2">
                                <div class="br-input"><label for="cpf">CPF</label>
                                    <input id="cpf" name="cpf" placeholder="Digite seu CPF" type="text" value="{{ $cpf }}" />
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="br-input"><label for="nome">Nome</label>
                                    <input id="nome" name="nome" placeholder="Digite seu nome" type="name" value="{{ $nome }}" />
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="br-select">
                                    <div class="br-input">
                                        <label for="select-simple">Tipo Pessoa</label>
                                        <input id="select-simple" type="text" placeholder="Selecione o item" />
                                        <button class="br-button" type="button" aria-label="Exibir lista" tabindex="-1" data-trigger="data-trigger"><i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="br-list" tabindex="0">
                                        @if($exists == true)
                                        <div class="br-item @if($tipo_pessoa == 'Militar') selected @endif" tabindex="-1">
                                            <div class="br-radio">

                                                <input id="Militar" type="radio" name="militar" @if($tipo_pessoa=='Militar' ) checked @endif />
                                                <label for="Militar">Servidor Militar</label>
                                            </div>
                                        </div>
                                        <div class="br-item @if($tipo_pessoa == 'Civil') selected @endif" tabindex="-1">
                                            <div class="br-radio">
                                                <input id="Civil" type="radio" name="civil" @if($tipo_pessoa=='Civil' ) checked @endif />
                                                <label for="Civil">Servidor Civil</label>
                                            </div>
                                        </div>
                                        @else
                                        <div class="br-item" tabindex="-1">
                                            <div class="br-radio">
                                                <input id="Outro Militar" type="radio" name="outro_militar" onclick="mostrarCampos()" />
                                                <label for="Outro Militar">Público Externo Militar</label>
                                            </div>
                                        </div>
                                        <div class="br-item" tabindex="-1">
                                            <div class="br-radio">
                                                <input id="Outro Civil" type="radio" name="outro_civil" onclick="esconderCampos()" />
                                                <label for="Outro Civil">Público Externo Civil</label>
                                            </div>
                                        </div>
                                        @endif

                                    </div>


                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="br-select">
                                    <div class="br-input">
                                        <label for="select-simple">Categoria Profissional</label>
                                        <input id="select-simple" type="text" placeholder="Selecione o item" />
                                        <button class="br-button" type="button" aria-label="Exibir lista" tabindex="-1" data-trigger="data-trigger"><i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="br-list" tabindex="0">
                                        <!-- asd -->
                                        @foreach ($categoria_profissional as $categoria_profisionais)
                                        <div class="br-item" tabindex="-1">
                                            <div class="br-radio">
                                                <input id="{{$categoria_profisionais->id}}" type="radio" name="categoria_profissional_id" value="{{$categoria_profisionais->id}}" />
                                                <label for="{{$categoria_profisionais->id}}">{{$categoria_profisionais->nome}}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                        <!-- end -->
                                    </div>
                                </div>
                            </div>

                        </div><br>

                        <div class="form-group row">

                            <div class="col-lg-2">
                                <div class="br-select">
                                    <div class="br-input">
                                        <label for="select-simple">Genero</label>
                                        <input id="select-simple" type="text" placeholder="Selecione o item" />
                                        <button class="br-button" type="button" aria-label="Exibir lista" tabindex="-1" data-trigger="data-trigger"><i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="br-list" tabindex="0">
                                        @foreach($generos['dados'] as $genero)
                                        <div class="br-item @if($genero['id'] == $genero_id) selected @endif" tabindex="-1">
                                            <div class="br-radio">
                                                <input id="{{'genero'.$genero['id']}}" type="radio" name="genero" value="{{ $genero['id'] }}" @if($genero['id']==$genero_id) checked @endif />
                                                <label for="{{'genero'.$genero['id']}}">{{ $genero['nome'] }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="br-select">
                                    <div class="br-input">
                                        <label for="select-simple">Estado Civil</label>
                                        <input id="select-simple" type="text" placeholder="Selecione o item" />
                                        <button class="br-button" type="button" aria-label="Exibir lista" tabindex="-1" data-trigger="data-trigger"><i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="br-list" tabindex="0">
                                        @foreach($estados_civis['dados'] as $estado_civil)
                                        <div class="br-item @if($estado_civil['id'] == $estado_civil_id) selected @endif" tabindex="-1">
                                            <div class="br-radio">
                                                <input id="{{'estado_civil'.$estado_civil['id']}}" type="radio" name="estado_civil" value="{{ $estado_civil['id'] }}" @if($estado_civil['id']==$estado_civil_id) checked @endif />
                                                <label for="{{'estado_civil'.$estado_civil['id']}}">{{ $estado_civil['nome'] }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="br-select">
                                    <div class="br-input">
                                        <label for="select-simple">Escolaridade</label>
                                        <input id="select-simple" type="text" placeholder="Selecione o item" />
                                        <button class="br-button" type="button" aria-label="Exibir lista" tabindex="-1" data-trigger="data-trigger"><i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="br-list" tabindex="0">
                                        @foreach($escolaridades['dados'] as $escolaridade)
                                        <div class="br-item @if($escolaridade['id'] == $escolaridade_id) selected @endif" tabindex="-1">
                                            <div class="br-radio">
                                                <input id="{{'escolaridade'.$escolaridade['id']}}" type="radio" name="escolaridade" value="{{ $escolaridade['id'] }}" @if($escolaridade['id']==$escolaridade_id) checked @endif />
                                                <label for="{{'escolaridade'.$escolaridade['id']}}">{{ $escolaridade['nome'] }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="br-input"><label for="email">Email</label>
                                    <input id="email" name="email" placeholder="Digite seu email" type="email" value="{{ $email }}" />
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="br-input"><label for="telefone">Telefone</label>
                                    <input name="telefone" id="telefone" type="telefone" maxlength="15" onkeyup="handlePhone(event)" value="{{ $telefone }}" />
                                </div>
                            </div>

                        </div>

                        <hr>

                        <div class="form-group row">

                            <div class="col-lg-2">
                                <div class="br-input"><label for="name">CEP</label>
                                    <input id="cep" name="cep" placeholder="Digite seu nome" type="text" value="{{ $cep }}" />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="br-input"><label for="email">Endereço</label>
                                    <input id="endereco" name="endereco" placeholder="Digite seu endereço" type="text" value="{{ $endereco }}" />
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="br-input"><label for="telefone">Bairro</label>
                                    <input id="bairro" name="bairro" type="text" value="{{ $bairro }}" />
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="br-input"><label for="email">Complemento</label>
                                    <input id="complemento" name="complemento" placeholder="Digite o complemento" type="text" value="{{ $complemento }}" />
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="br-input"><label for="email">Cidade</label>
                                    <input id="cidade_uf" name="cidade_uf" placeholder="Digite sua cidade" type="text" value="{{ $cidade }}" />
                                </div>
                            </div>
                        </div>



                        @if($tipo_pessoa == "Militar" || $tipo_pessoa == "")
                        <hr>


                        <div class="form-group row">
                            <div class="col-lg-3" id="forca_id">
                                <div class="br-select">
                                    <div class="br-input">
                                        <label for="select-simple">Força</label>
                                        <input id="select-simple" type="text" placeholder="Selecione o item" />
                                        <button class="br-button" type="button" aria-label="Exibir lista" tabindex="-1" data-trigger="data-trigger"><i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="br-list" tabindex="0">
                                        @foreach($forcas['dados'] as $forca)
                                        <div class="br-item @if($forca['id'] == $forca_id) selected @endif" tabindex="-1">
                                            <div class="br-radio">
                                                <input id="{{'forca'.$forca['id']}}" type="radio" name="forca" @if($forca['id']==$forca_id) checked @endif />
                                                <label for="{{'forca'.$forca['id']}}">{{ $forca['nome'] }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3" id="qualificacao_id">
                                <div class="br-select">
                                    <div class="br-input">
                                        <label for="select-simple">Qualificação Militar</label>
                                        <input id="select-simple" type="text" placeholder="Selecione o item" />
                                        <button class="br-button" type="button" aria-label="Exibir lista" tabindex="-1" data-trigger="data-trigger"><i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="br-list" tabindex="0">
                                        @foreach($qualificacoes['dados'] as $qualificacao)
                                        <div class="br-item @if($qualificacao['id'] == $qualificacoes_id) selected @endif" tabindex="-1">
                                            <div class="br-radio">
                                                <input id="{{'qualificacao'.$qualificacao['id']}}" type="radio" name="qualificacao" value="{{ $qualificacao['id'] }}" @if($qualificacao['id']==$qualificacoes_id) checked @endif />
                                                <label for="{{'qualificacao'.$qualificacao['id']}}">{{ $qualificacao['nome'] }}</label>
                                            </div>
                                        </div>

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @if($exists == false)
                            <div class="col-lg-3">
                                <div class="br-input"><label for="email">Senha</label>
                                    <input id="senha" placeholder="Digite uma senha" type="password" />
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="br-input"><label for="email">Confirmar Senha</label>
                                    <input id="senha_2" placeholder="Confirme a senha" type="password" />
                                </div>
                            </div>
                            @endif
                        </div><br>

                        <div class="form-group row">
                            <div class="col-lg-3" id="especialidade_id">
                                <div class="br-select">
                                    <div class="br-input">
                                        <label for="select-simple">Especialidade</label>
                                        <input id="select-simple" type="text" placeholder="Selecione o item" />
                                        <button class="br-button" type="button" aria-label="Exibir lista" tabindex="-1" data-trigger="data-trigger"><i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="br-list" tabindex="0">
                                        @foreach($especialidades['dados'] as $especialidade)
                                        <div class="br-item @if($especialidade['id'] == $especialidade_id) selected @endif" tabindex="-1">
                                            <div class="br-radio">
                                                <input id="{{'especialidade'.$especialidade['id']}}" type="radio" name="especialidade" value="{{ $especialidade['id'] }}" @if($especialidade['id']==$especialidade_id) checked @endif />
                                                <label for="{{'especialidade'.$especialidade['id']}}">{{ $especialidade['nome'] }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3" id="posto_id">
                                <div class="br-select">
                                    <div class="br-input">
                                        <label for="select-simple">Posto Graduação</label>
                                        <input id="select-simple" type="text" placeholder="Selecione o item" />
                                        <button class="br-button" type="button" aria-label="Exibir lista" tabindex="-1" data-trigger="data-trigger"><i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="br-list" tabindex="0">
                                        @foreach($postos['dados'] as $posto)
                                        <div class="br-item @if($posto['id'] == $posto_graduacao_id) selected @endif" tabindex="-1">
                                            <div class="br-radio">
                                                <input id="{{'posto'.$posto['id']}}" type="radio" name="posto" value="{{ $posto['id'] }}" @if($posto['id']==$posto_graduacao_id) checked @endif />
                                                <label for="{{'posto'.$posto['id']}}">{{ $posto['nome'] }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div><br>
                        <div class="form-group row">
                            <div class="col-lg-3" id="status_id">
                                <div class="br-select">
                                    <div class="br-input">
                                        <label for="select-simple">Status Militar</label>
                                        <input id="select-simple" type="text" placeholder="Selecione o item" />
                                        <button class="br-button" type="button" aria-label="Exibir lista" tabindex="-1" data-trigger="data-trigger"><i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="br-list" tabindex="0">
                                        @foreach($status_militar['dados'] as $status)
                                        <div class="br-item @if($status['id'] == $status_militar_id) selected @endif" tabindex="-1">
                                            <div class="br-radio">
                                                <input id="{{'status'.$status['id']}}" type="radio" name="status" value="{{ $status['id'] }}" @if($status['id']==$status_militar_id) selected @endif />
                                                <label for="{{'status'.$status['id']}}">{{ $status['nome'] }}</label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>




                        @endif
                        <br><br>

                        <div align="center">
                            <button class="br-button primary mr-3" id="enviarInscr" type="button" onclick="return executarCriar()">Enviar</button>
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
<script>
    const selectList = []
    const notFoundElement = `
        <div class="br-item not-found">
        <div class="container">
        <div class="row">
            <div class="col">
            <p><strong>Ops!</strong> Não encontramos o que você está procurando!</p>
            </div>
        </div>
        </div>
        </div>
        `
    for (const brSelect of window.document.querySelectorAll('.br-select')) {
        const brselect = new core.BRSelect('br-select', brSelect, notFoundElement)
        //Exemplo de uso de listener do select
        brSelect.addEventListener('onChange', function(e) {})
        selectList.push(brselect)
    }
</script>


@include('site.contato.js')

@include('site.site-layout.footer')