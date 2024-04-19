@extends('layouts.master')

@section('content')
    <x-container fluid>
        <x-card>
            <x-card-header class="d-flex align-item-center justify-content-between">
                <div class="fs-5">
                    E-Code
                </div>
                <a href="{{ route('site.ecode.create') }}" class="ms-2 btn btn-sm btn-primary d-flex align-items-center gap-2">
                    <span class="material-icons-round fs-5">add</span>
                    สร้าง
                </a>
            </x-card-header>
            <x-card-body>
                <x-datatable>
                    <thead>
                        <tr>
                            <th>ชื่อแคมเปญ</th>
                            <th>Partner / Department</th>
                            <th width="1%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($campaigns as $campaign)
                            <tr>
                                <td>{{ $campaign->name }}</td>
                                <td>{{ $campaign->owner->name }}</td>
                                <td class="text-center d-flex">
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="แดชบอร์ด"
                                        class="btn btn-sm btn-info m-1" type="button"
                                        href="{{ route('site.ecode.dashboard', $campaign->id) }}">
                                        <i class="material-icons-round fs-6">grid_view</i>
                                    </a>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="แก้ไข"
                                        class="btn btn-sm btn-warning m-1" type="button"
                                        href="{{ route('site.ecode.edit', $campaign->id) }}">
                                        <i class="material-icons-round fs-6">edit</i>
                                    </a>
                                    <form data-bs-toggle="tooltip" data-bs-placement="top" class="d-inline" method="post"
                                        action="{{ route('site.ecode.destroy', $campaign->id) }}" id="delete-campaign">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm btn-danger m-1" type="submit" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="ลบแคมเปญ">
                                            <i class="material-icons-round fs-6">delete</i>
                                        </button>
                                    </form>
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
        $(document).ready(function() {
            $('form#delete-campaign').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'คุณแน่ใจใช่ไหม?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'ลบ',
                    cancelButtonText: 'ย้อนกลับ',
                    focusConfirm: false,
                    focusCancel: true,
                    showClass: {
                        popup: "animate__animated animate__headShake animate__faster"
                    },
                }).then((action) => {
                    if (action.isConfirmed) {
                        e.currentTarget.submit();
                    }
                })
            });
        });
    </script>
@endsection
