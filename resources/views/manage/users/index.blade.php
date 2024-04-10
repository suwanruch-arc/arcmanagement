@extends('layouts.app', ['route' => route('dashboard')])

@section('title')
    <h3>Users</h3>
@endsection

@section('content')
    <x-container fluid>
        <x-card>
            <x-card-header class="d-flex align-item-center justify-content-between">
                <div class="fs-5">
                    ผู้ใช้งาน
                </div>
                <x-header-btn justify="end"/>
            </x-card-header>
            <x-card-body>
                <x-datatable sort>
                    <thead>
                        <tr>
                            <th width="10%">Name</th>
                            <th width="10%">Email</th>
                            <th width="10%">Username</th>
                            <th width="10%">Contact Number</th>
                            <th width="10%">Partner</th>
                            <th width="10%">Department</th>
                            <th width="5%">Position</th>
                            <th width="5%">Role</th>
                            <th width="5%">From</th>
                            <th width="5%">Password</th>
                            <th width="1%">Status</th>
                            <th width="9%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ Str::mask($user->email, '*', -21, 3) }}</td>
                                <td>{{ $user->username }}</td>
                                <td class="text-center">
                                    {{ Str::mask($user->contact_number, '*', 7) }}
                                </td>
                                <td>
                                    {!! $user->partner->name ?? '<i>ไม่ได้ตั้งค่า</i>' !!}
                                </td>
                                <td>
                                    {!! $user->department->name ?? '<i>ไม่ได้ตั้งค่า</i>' !!}
                                </td>
                                <td class="fw-bold text-capitalize text-center">
                                    {{ $user->position }}
                                </td>
                                <td class="fw-bold text-capitalize text-center">
                                    {{ $user->role }}
                                </td>
                                <td class="fw-bold text-uppercase text-center">
                                    {{ $user->from }}
                                </td>
                                <td class=" text-center">
                                    <button class="btn btn-link"
                                        onclick="resetPassword({{ $user->id }})">รีเซ็ต</button>
                                </td>
                                <td class="text-center">
                                    {!! Status::show($user->status) !!}
                                </td>
                                <td class="text-center">
                                    <x-action-btn :model="$user" route="manage.users" :params="['user' => $user->id]" />
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </x-datatable>
            </x-card-body>
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
