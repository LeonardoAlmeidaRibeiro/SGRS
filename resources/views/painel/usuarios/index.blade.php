 @include('../layout.header')

 <style>
     .dropdown-toggle,
     .bs-placeholder,
     .btn-light {
         height: 3.3rem !important;
     }

     .inner,
     .show {
         max-width: 100% !important;

     }
 </style>


 <!--begin::Conteúdo-->
 <div id="kt_content" class="content d-flex flex-column flex-column-fluid">
     <!--begin::Post-->
     <div id="kt_post" class="post d-flex flex-column-fluid">
         <!--begin::Container-->
         <div id="kt_content_container" class="container-fluid">

             <!--begin::Tabela-->
             <div class="card mb-5 mb-xl-5">
                 <!--begin::Header-->
                 <div class="card-body">

                     <form class="form" action="{{ route('usuario.index') }}" method="GET">
                         @csrf
                         <div class="form-group row">
                             <h3 class="card-title align-items-start flex-column">
                                 <span class="card-label fw-bolder fs-3 mb-1">Consulta de Usuário</span>
                             </h3>
                         </div>

                         <div class="form-group row">

                             <div class="col-lg-3">

                                 <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                     <span>Nome</span>
                                 </label>

                                 <select id="nome" class="form-control form-control-solid selectpicker"
                                     data-live-search="true" name="nome">
                                     <option value="">Selecione</option>
                                     @foreach ($users as $user)
                                         <option value="{{ $user->name }}" @if(in_array($user->id, $names)) selected @endif> {{ $user->name }}</option>
                                     @endforeach
                                 </select>

                             </div>

                             <div class="col-lg-3">

                                 <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                     <span>Email</span>
                                 </label>

                                 <input id="email" type="text" class="form-control form-control-solid"
                                     name="email"
                                     value="@if (isset($dados['email'])) {{ $dados['email'] }} @endif" />

                             </div>

                             <div class="col-lg-3">

                                 <label class="d-flex align-items-center fs-6 fw-bold form-label">
                                     <span>Perfil</span>
                                 </label>
                                 <select id="perfil" class="form-control form-control-solid" name="perfil">
                                     <option value="">Selecione</option>
                                     @foreach ($perfis as $perfil)
                                         <option value="{{ $perfil->id }}"
                                             @if (isset($dados['perfil'])) @if ($dados['perfil'] == $perfil->id) selected @endif
                                             @endif>{{ $perfil->nome }}</option>
                                     @endforeach
                                 </select>
                             </div>

                         </div>

                         <br>

                         <div class="form-group row">

                             <div class="col-lg-12" align="left">
                                 <button type="submit" class="btn btn-sm btn-light-primary">Buscar</button>
                             </div>

                         </div>

                     </form>

                 </div>
             </div>

             <!--begin::Tabela-->
             <div class="card mb-5 mb-xl-8">
                 <!--begin::Header-->
                 <div class="card-header border-0 pt-5">
                     <h3 class="card-title align-items-start flex-column">
                         <span class="card-label fw-bolder fs-3 mb-1">Usuários</span>
                         <span class="text-muted mt-1 fw-bold fs-7">Listagem de Usuários</span>
                     </h3>

                 </div>
                 <!--end::Header-->
                 <!--begin::Body-->
                 <div class="card-body py-3">
                     <!--begin::Table container-->
                     <div class="table-responsive">
                         <!--begin::Table-->
                         <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                             <!--begin::Table head-->
                             <thead>
                                 <tr class="fw-bolder text-muted bg-secondary">
                                     <th class="ps-4 min-w-125px rounded-start">Nome</th>
                                     <th class="min-w-125px">Email</th>
                                     <th class="min-w-125px">Perfil</th>
                                     <th class="min-w-200px text-end rounded-end"></th>
                                 </tr>
                             </thead>
                             <!--end::Table head-->
                             <!--begin::Table body-->
                             <tbody>

                                 @foreach ($users as $user)
                                     <tr id="tr_{{ $user->id }}">
                                      
                                            <td> 
                                                <a href="#" onClick="return abrirModalEditar({{ $user->id }});"
                                                    class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"
                                                    data-bs-toggle="modal" data-bs-target="#modal_editar">
                                                    <div id="celula_a_{{ $user->id }}">
                                                        {{ $user->name }}
                                                    </div>
                                                </a>
                                            </td>
                                            <td> 
                                                <a href="#" onClick="return abrirModalEditar({{ $user->id }});"
                                                    class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"
                                                    data-bs-toggle="modal" data-bs-target="#modal_editar">
                                                    <div id="celula_b_{{ $user->id }}">
                                                        {{ $user->email }}
                                                        </div>
                                                </a>
                                            </td>
                                            <td>
                                                <input id="perfil_id_{{ $user->id }}" type="hidden"
                                                    value="{{ $user->perfil_id }}" />
                                                
                                                    <a href="#" onClick="return abrirModalEditar({{ $user->id }});"
                                                        class="text-dark fw-bolder text-hover-primary d-block mb-1 fs-6"
                                                        data-bs-toggle="modal" data-bs-target="#modal_editar">
                                                        <div id="celula_c_{{ $user->id }}">
                                                            {{ $user->perfil }}
                                                        </div>
                                                    </a>
                                                </td>
                                                     
                                                <td class="text-end">

                                                    <div class="card-toolbar">
                                                        <a href="#" class="btn btn-sm btn-light-primary"
                                                            onClick="return abrirModalEditar('{{ $user->id }}');"
                                                            data-bs-toggle="modal" data-bs-target="#modal_editar">
                                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                                            <span class="svg-icon svg-icon-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path opacity="0.3"
                                                                        d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                                        fill="black" />
                                                                    <path
                                                                        d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                                        fill="black" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->Editar
                                                        </a>



                                                    </div>

                                                </td>
                                                   
                                                 </tr>
                                             @endforeach

                                         </tbody>
                                         <!--end::Table body-->
                                     </table>
                                     <!--end::Table-->
                                        <div class="d-flex justify-content-between mb-3">
                                            <div class="fs-6" colspan="5">@php echo "Total de ".sizeof($users)." registro(s)." @endphp</div>
                                            {{ $users->appends($dados)->links() }}

                                        </div>
                                 </div>
                                 <!--end::Table container-->
                             </div>
                             <!--begin::Body-->
                         </div>
                         <!--end::Tabela-->


                         @include('painel.usuarios.editar')


                     </div>
                 </div>
             </div>


             @include('layout.footer')

             <link href="{{ url('assets/css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
             <link rel="stylesheet" href="{{ url('assets/css/bootstrap-select.css') }}" type="text/css" />
             <script src="{{ url('assets/js/datatables.bundle.js') }}"></script>
             <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
             <script src="{{ url('assets/js/bootstrap-select.min.js') }}"></script>

             @include('painel.usuarios.js')

             </body>
             <!--end::Body-->

             </html>
