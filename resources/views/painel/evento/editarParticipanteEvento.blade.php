<!--begin::Modal - Editar-->
<div class="modal fade" id="modal_editar_participante_evento" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Alterar Participação</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form class="form" action="#">

                    <!--begin::Input group-->
                    <div class="d-flex flex-column mb-7 fv-row">
                        <input type="hidden" id="id_edit" name="id_edit" />
                        <div class="row">
                            <div class="col">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required">Conhecimento do Evento</span>
                                </label>
                                <select select class="form-control form-control-solid" id="conhecimento_evento_edit" name="conhecimento_evento_edit">
                                    <option value="">Selecione</option>
                                    @foreach ($forma_conhecimento as $forma_conhecimentos )
                                    <option value="{{$forma_conhecimentos->id}}">{{$forma_conhecimentos->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required">Forma de Inscrição</span>
                                </label>
                                <select select class="form-control form-control-solid" id="forma_inscricao_edit" name="forma_inscricao_edit">
                                    <option value="">Selecione</option>
                                    @foreach ( $forma_inscricao as $forma_inscricaos )
                                    <option value="{{$forma_inscricaos->id}}">{{$forma_inscricaos->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-100"><br></div>
                            <div class="col">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required">Participante</span>
                                </label>
                                <select select class="form-control form-control-solid" id="participante_edit" name="participante_edit">
                                    <option value="">Selecione</option>
                                    <option value="S">Sim</option>
                                    <option value="N">Não</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required">Palestrante</span>
                                </label>
                                <select select class="form-control form-control-solid" id="palestrante_edit" name="palestrante_edit">
                                    <option value="">Selecione</option>
                                    <option value="S">Sim</option>
                                    <option value="N">Não</option>
                                </select>
                            </div>
                            <div class="w-100"><br></div>
                            <div class="col">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required">Organizador</span>
                                </label>
                                <select select class="form-control form-control-solid" id="organizador_edit" name="organizador_edit">
                                    <option value="">Selecione</option>
                                    <option value="S">Sim</option>
                                    <option value="N">Não</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                    <span class="required">Ouvinte</span>
                                </label>
                                <select select class="form-control form-control-solid" id="ouvinte_edit" name="ouvinte_edit">
                                    <option value="">Selecione</option>
                                    <option value="S">Sim</option>
                                    <option value="N">Não</option>
                                </select>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="button" id="cancelar" class="btn btn-danger" data-bs-dismiss="modal">
                                <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen040.svg-->
                                <span class="svg-icon svg-icon-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black" />
                                        <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="black" />
                                        <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="black" />
                                    </svg></span>
                                <!--end::Svg Icon-->
                                Cancelar
                            </button>
                            <button type="button" id="editarParticipante" class="btn btn-primary" onclick="executarModalEditarParticipante()">
                                <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen043.svg-->
                                <span class="svg-icon svg-icon-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black" />
                                        <path d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z" fill="black" />
                                    </svg></span>
                                <!--end::Svg Icon-->
                                Salvar
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->

        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Editar-->