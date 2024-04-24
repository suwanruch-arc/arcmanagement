@extends('layouts.master')

@section('content')
    <x-container fluid>
        <x-card>
            <x-card.header class="justify-content-between pe-2">
                <div class="fs-5">
                    ผู้ใช้งาน
                </div>
                <x-header-btn justify="end" />
            </x-card.header>
            <x-card.body>
                <x-table :columns="$columns"/>
            </x-card.body>
        </x-card>
    </x-container>
@endsection

@section('js')
    <script>
        function resetPassword(id) {
            Swal.fire({
                icon: 'warning',
                title: 'คุณต้องการ รีเซ็ตรหัสผ่าน หรือไม่?',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'รีเซ็ต',
                cancelButtonText: 'ย้อนกลับ',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('account.reset-password') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response) {
                                Swal.fire('Saved!', '', 'success')
                            } else {
                                Swal.fire('Error!', '', 'error')
                            }
                        },
                        error: function(response) {
                            Swal.fire('Error!', '', 'error')
                        }
                    });
                }
            })
        }
    </script>
@endsection
