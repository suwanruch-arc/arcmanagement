@extends('layouts.master')

@section('content')
    <x-container fluid>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" width="1%">#</th>
                <th scope="col" width="15%">Name</th>
                <th scope="col">Email</th>
                <th scope="col" width="10%">Username</th>
            </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->username }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $users->links() !!}
        </div>
        {{-- <x-table label="ผู้ใช้งาน" :columns="$columns">
            <x-slot name="btn">
                asd
            </x-slot>
        </x-table> --}}
        {{-- <x-card>
            <x-card.header class="justify-content-between pe-2">
                <div class="fs-5">
                    ผู้ใช้งาน
                </div>
                <x-header-btn justify="end" />
            </x-card.header>
            <x-card.body>
                <x-table :columns="$columns"/>
            </x-card.body>
        </x-card> --}}
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
