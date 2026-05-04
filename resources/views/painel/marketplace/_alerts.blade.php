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
