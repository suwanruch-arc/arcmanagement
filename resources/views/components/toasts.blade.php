@if (session('success'))
    @php
        $type = 'success';
        $message = session('success');
    @endphp
@endif

@if (session('error'))
    @php
        $type = 'error';
        $message = session('error');
    @endphp
@endif

@if (session('message'))
    @php
        $type = 'warning';
        $message = session('message');
    @endphp
@endif

@if (session('success') || session('error') || session('message'))
    <script>
        Swal.fire({
            toast: true,
            title: 'การแจ้งเตือน',
            text: "{!! $message !!}",
            icon: '{{ $type }}',
            position: "top-end",
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
        })
    </script>
@endif
