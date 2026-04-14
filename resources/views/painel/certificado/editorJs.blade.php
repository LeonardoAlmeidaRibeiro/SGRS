<script>
    class MyUploadAdapter {
        constructor( loader , url) {
            // The file loader instance to use during the upload.
            this.loader = loader;
            this.url = url;
        }

        // Starts the upload process.
        upload() {
            return this.loader.file
                .then( file => new Promise( ( resolve, reject ) => {
                    this._initRequest();
                    this._initListeners( resolve, reject, file );
                    this._sendRequest( file );
                } ) );
        }

        // Aborts the upload process.
        abort() {
            if ( this.xhr ) {
                this.xhr.abort();
            }
        }

        // Initializes the XMLHttpRequest object using the URL passed to the constructor.
        _initRequest() {
            const xhr = this.xhr = new XMLHttpRequest();

            // Note that your request may look different. It is up to you and your editor
            // integration to choose the right communication channel. This example uses
            // a POST request with JSON as a data structure but your configuration
            // could be different.
            xhr.open( 'POST', this.url, true );
            xhr.setRequestHeader("x-csrf-token", "{{ csrf_token() }}");
            xhr.responseType = 'json';

        }

        // Initializes XMLHttpRequest listeners.
        _initListeners( resolve, reject, file ) {
            
            const xhr = this.xhr;
            const loader = this.loader;
            const genericErrorText = `Couldn't upload file: ${ file.name }.`;

            xhr.addEventListener( 'error', () => reject( genericErrorText ) );
            xhr.addEventListener( 'abort', () => reject() );
            xhr.addEventListener( 'load', () => {
                
                const response = xhr.response;

                // This example assumes the XHR server's "response" object will come with
                // an "error" which has its own "message" that can be passed to reject()
                // in the upload promise.
                //
                // Your integration may handle upload errors in a different way so make sure
                // it is done properly. The reject() function must be called when the upload fails.
                if ( !response || response.error ) {
                    return reject( response && response.error ? response.error.message : genericErrorText );
                }

                // If the upload is successful, resolve the upload promise with an object containing
                // at least the "default" URL, pointing to the image on the server.
                // This URL will be used to display the image in the content. Learn more in the
                // UploadAdapter#upload documentation.
                resolve( {
                    default: response.url
                } );
            } );

            // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
            // properties which are used e.g. to display the upload progress bar in the editor
            // user interface.
            if ( xhr.upload ) {
                xhr.upload.addEventListener( 'progress', evt => {
                    if ( evt.lengthComputable ) {
                        loader.uploadTotal = evt.total;
                        loader.uploaded = evt.loaded;
                    }
                } );
            }
        }

        // Prepares the data and sends the request.
        _sendRequest( file ) {
            // Prepare the form data.
            const data = new FormData();
            
            data.append( 'upload', file );
            
            // Important note: This is the right place to implement security mechanisms
            // like authentication and CSRF protection. For instance, you can use
            // XMLHttpRequest.setRequestHeader() to set the request headers containing
            // the CSRF token generated earlier by your application.

            // Send the request.
            this.xhr.send( data );
        }
    }

    function MyCustomUploadAdapterPlugin( editor ) {
        
        editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
            url = editor.url;
            return new MyUploadAdapter( loader , url);
        };
        
    }
    

    ClassicEditor
        .create( document.querySelector( '#texto_id' ), {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
                  
        } )
        .then( editor => {
            editor.url = document.querySelector( '#texto_id' ).getAttribute('data-url');
            // console.log( error );
        } )
        .catch( error => {
            // console.log( error );
        } );

    ClassicEditor
        .create( document.querySelector( '#assinatura_1_id' ), {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
            
        } )
        .then( editor => {
            editor.url = document.querySelector( '#assinatura_1_id' ).getAttribute('data-url');
            // console.log( editor );
        } )
        .catch( error => {
            // console.log( error );
        } );
    
    ClassicEditor
        .create( document.querySelector( '#assinatura_2_id' ), {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
            
        } )
        .then( editor => {
            editor.url = document.querySelector( '#assinatura_2_id' ).getAttribute('data-url');
             //console.log( editor.data-url );
        } )
        .catch( error => {
            // console.log( error );
        } );

    ClassicEditor
        .create( document.querySelector( '#assinatura_3_id' ), {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
            
        } )
        .then( editor => {
            editor.url = document.querySelector( '#assinatura_3_id' ).getAttribute('data-url');
            // console.log( editor );
        } )
        .catch( error => {
            // console.log( error );
        } );

    ClassicEditor
        .create( document.querySelector( '#cont_progra_id' ), {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
            
        } )
        .then( editor => {
            editor.url = document.querySelector( '#cont_progra_id' ).getAttribute('data-url');
            // console.log( editor );
        } )
        .catch( error => {
            // console.log( error );
        } );
    
    ClassicEditor
        .create( document.querySelector( '#texto_verso_id' ), {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
            
        } )
        .then( editor => {
            editor.url = document.querySelector( '#texto_verso_id' ).getAttribute('data-url');
            // console.log( editor );
        } )
        .catch( error => {
            // console.log( error );
        } );

    ClassicEditor
        .create( document.querySelector( '#assinatura_verso_id' ), {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
            
        } )
        .then( editor => {
            editor.url = document.querySelector( '#assinatura_verso_id' ).getAttribute('data-url');
            // console.log( editor );
        } )
        .catch( error => {
            // console.log( error );
        } );

    ClassicEditor
        .create( document.querySelector( '#logo_superior_id' ), {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
            
        } )
        .then( editor => {
            editor.url = document.querySelector( '#logo_superior_id' ).getAttribute('data-url');
            // console.log( editor );
        } )
        .catch( error => {
            // console.log( error );
        } );

    ClassicEditor
        .create( document.querySelector( '#logos_inferiores_id' ), {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
            
        } )
        .then( editor => {
            editor.url = document.querySelector( '#logos_inferiores_id' ).getAttribute('data-url');
        } )
        .catch( error => {
            // console.log( error );
        } );

    var editorFrente;
    ClassicEditor
        .create( document.querySelector( '#frente_personalizada' ), {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
            
        } )
        .then( editor => {
            editor.url = document.querySelector( '#frente_personalizada' ).getAttribute('data-url');
            editorFrente = editor;
        } )
        .catch( error => {
            // console.log( error );
        } );

    var editorVerso;
    ClassicEditor
        .create( document.querySelector( '#verso_personalizado' ), {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
            
        } )
        .then( editor => {
            editor.url = document.querySelector( '#verso_personalizado' ).getAttribute('data-url');
            editorVerso = editor;
        } )
        .catch( error => {
            // console.log( error );
        } );




    function AbrirEditar(id, tipo_participacao){
        if(tipo_participacao == 'Palestrante'){
            var texto_frente = $('#texto_frente_palestrante_'+id).val();
            var texto_verso = $('#texto_verso_palestrante_'+id).val();
        }
        if(tipo_participacao == 'Organizador do Evento'){
            var texto_frente = $('#texto_frente_organizador_'+id).val();
            var texto_verso = $('#texto_verso_organizador_'+id).val();
        }

        var id_evento = $('#id_evento').val();

        $('#evento_id').val(id_evento);
        $('#inscricao_id').val(id);
        $('#tipo_certificado').val(tipo_participacao);

        editorFrente.setData(texto_frente);
        editorVerso.setData(texto_verso);

    }

    function EditarCertPersonalizado() {
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

        var evento_id = $('#evento_id').val();
        var id_inscricao = $('#inscricao_id').val();
        var tipo_certificado = $('#tipo_certificado').val();
        var frente = editorFrente.getData();
        var verso = editorVerso.getData();
        
        dados = {
            "evento_id":evento_id,
            "inscricao_id":id_inscricao,
            "tipo_certificado":tipo_certificado,
            'frente':frente,
            'verso':verso
        };
        
        $.ajax({
            url: "{{ route('certificadoPersonalizado.store') }}",
            type: "POST",
            data: dados,
            headers: headers,
            error: function(data) {
                
                if(data.status === 422) {
                    var message = '';
                    $.each(data.responseJSON.errors, function(campo, conteudo) {
                        message = message.concat(conteudo);
                    });
                    Swal.fire({ icon: 'error', title: 'Oops...', text: message });
                }

            },
            success: function(data) {
                
                $('#certificado_personalizado').modal('toggle');
                
                var inscricao_id = '';
                var message = '';
                var success = '';
                var data_editada = '';
                var tipo_certificado = '';
                
                $.each(data, function(campo, conteudo) {
                    if(campo == 'inscricao_id'){
                        inscricao_id = conteudo;
                    }
                    if(campo == 'success'){
                        success = conteudo;
                    }
                    if(campo == 'message'){
                        message = conteudo;
                    }
                    if(campo == 'editado_em'){
                        data_editada = conteudo;
                    }
                    if(campo == 'tipo_certificado'){
                        tipo_certificado = conteudo;
                    }
                });
                
                if(success == true){
                    campo_data = '<a class="text-dark fw-bolder d-block mb-1 fs-6">' + data_editada + '</a>';
                    if(tipo_certificado == 'Palestrante'){
                        $('#Palestrante_editado_em_'+inscricao_id).html(campo_data);
                        
                    }else{
                        
                        $('#Organizador_editado_em_'+inscricao_id).html(campo_data);
                    }
                    Swal.fire({ icon: 'success', title: 'Sucesso!', text: message });
                }else{
                    Swal.fire({ icon: 'error', title: 'Oops...', text: message });
                }
                

            }
        });

    }
</script>