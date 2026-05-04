@if (session('swal_success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: @json(session('swal_success'))
        });
    </script>
@endif

@if (session('swal_error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: @json(session('swal_error'))
        });
    </script>
@endif

@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Confira os campos',
            html: @json(implode('<br>', $errors->all()))
        });
    </script>
@endif
