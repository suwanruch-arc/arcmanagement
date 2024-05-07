@extends('layouts.master')

@section('content')
    <x-container fluid>
        <x-card>
            <x-card.body>
                <div class="d-flex justify-content-between">
                    <div class="fs-5">
                        ผู้ใช้งาน
                    </div>
                    <x-button label="เพิ่มผู้ใช้งาน" icon="add" color="outline-secondary" size="sm"
                        :href="route('manage.users.create')" />
                </div>
                <hr />
                <form class="mb-3 d-flex gap-2">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search" placeholder="ค้นหาข้อมูล"
                            value="{{ $_GET['search'] ?? '' }}" />
                        <button class="btn btn-primary" type="submit" id="search-btn">
                            ค้นหา
                        </button>
                    </div>
                    @if (isset($_GET['search']))
                        <button class="btn btn-outline-secondary" type="button" id="clear-btn"
                            onclick="window.location = window.location.href.split('?')[0]">
                            ล้าง
                        </button>
                    @endif
                </form>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th width="1%">สถานะ</th>
                                <th width="10%">ชื่อ</th>
                                <th width="10%">อีเมล</th>
                                <th width="10%">ชื่อผู้ใช้งาน</th>
                                <th width="10%">เบอร์ติดต่อ</th>
                                <th width="10%">Partner</th>
                                <th width="10%">Department</th>
                                <th width="5%">ตำแหน่ง</th>
                                <th width="5%">สิทธิ์</th>
                                <th width="5%">ข้อมูลจาก</th>
                                <th width="5%">รหัสผ่าน</th>
                                <th width="9%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $value)
                                <tr>
                                    <td class="text-center">
                                        {!! Status::show($value->status) !!}
                                    </td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ Str::mask($value->email, '*', -21, 3) }}</td>
                                    <td>{{ $value->username }}</td>
                                    <td class="text-center">
                                        {{ Str::mask($value->contact_number, '*', 7) }}
                                    </td>
                                    <td>
                                        {!! $value->partner->name ?? '<i>ไม่ได้ตั้งค่า</i>' !!}
                                    </td>
                                    <td>
                                        {!! $value->department->name ?? '<i>ไม่ได้ตั้งค่า</i>' !!}
                                    </td>
                                    <td class="fw-bold text-capitalize text-center">
                                        {{ $value->position }}
                                    </td>
                                    <td class="fw-bold text-capitalize text-center">
                                        {{ $value->role }}
                                    </td>
                                    <td class="fw-bold text-uppercase text-center">
                                        {{ $value->from }}
                                    </td>
                                    <td class=" text-center">
                                        <button class="btn btn-link"
                                            onclick="resetPassword({{ $value->id }})">รีเซ็ต</button>
                                    </td>
                                    <td class="text-center">
                                        <x-action-btn :model="$value" route="manage.users" :params="['user' => $value->id]" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">ไม่มีข้อมูล</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {!! $data->links() !!}
                </div>
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
