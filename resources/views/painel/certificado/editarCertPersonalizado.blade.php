<div class="modal fade" id="certificado_personalizado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Editar Certificado</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </div>
                <!--end::Close-->
            </div>

            <form>
                <div class="modal-body scroll-y mx-5 mx-xl-15 ">
                    <div class="mb-5">
                        <input type="hidden" id="inscricao_id" >
                        <input type="hidden" id="evento_id" >
                        <input type="hidden" id="tipo_certificado" >
                        <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span>Frente</span>
                        </label>
                        <textarea class="ckeditor form-control" data-url="" name="frente_personalizada" id="frente_personalizada">
                        </textarea>
                    </div>
                    <div>
                        <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span>Verso</span>
                        </label>
                        <textarea class="ckeditor form-control" data-url="" name="verso_personalizado" id="verso_personalizado">
                            
                        </textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="EditarCertPersonalizado()">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

