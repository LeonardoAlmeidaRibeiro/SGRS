@include('layout.header')

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div id="kt_post" class="post d-flex flex-column-fluid">
        <div id="kt_content_container" class="container-fluid">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Editar Resíduo</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Atualize as informações do resíduo</span>
                    </h3>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('residuos.update', $residuo->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('painel.residuos._form')

                        <div class="text-end">
                            <a href="{{ route('residuos.index') }}" class="btn btn-light">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Salvar alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layout.footer')
@include('painel.residuos._alerts')

</body>
</html>
