@extends('layouts.master', ['route' => url()->previous()])

@section('content')
<x-section>
    <x-slot name="title">
        <span class="material-symbols-rounded">
            group
        </span>
        ผู้ใช้งาน
    </x-slot>
    <x-slot name="toolbar">
        <x-button label="เพิ่มผู้ใช้งาน" icon="add" color="primary" />
    </x-slot>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col" class="text-center" width="1%">สถานะ</th>
                    <th scope="col" class="text-center" width="10%">ชื่อ</th>
                    <th scope="col" class="text-center" width="10%">อีเมล</th>
                    <th scope="col" class="text-center" width="10%">ชื่อผู้ใช้งาน</th>
                    <th scope="col" class="text-center" width="10%">เบอร์ติดต่อ</th>
                    <th scope="col" class="text-center" width="10%">Partner</th>
                    <th scope="col" class="text-center" width="10%">Department</th>
                    <th scope="col" class="text-center" width="7%">ตำแหน่ง</th>
                    <th scope="col" class="text-center" width="5%">สิทธิ์</th>
                    <th scope="col" class="text-center" width="7%">ข้อมูลจาก</th>
                    <th scope="col" class="text-center" width="5%">รหัสผ่าน</th>
                    <th scope="col" class="text-center" width="9%"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $value)
                    <tr>
                        <td class="td-center">

                        </td>
                        <td class="align-middle">
                            {{ $value->name }}
                        </td>
                        <td class="align-middle">
                            {!! $value->email ?? '---' !!}
                        </td>
                        <td class="align-middle">
                            {{ $value->username }}
                        </td>
                        <td class="td-center">
                            {!! $value->contact_number ?? '---' !!}
                        </td>
                        <td class="td-center">
                            {!! $value->partner->name ?? '---' !!}
                        </td>
                        <td class="td-center">
                            {!! $value->department->name ?? '---' !!}
                        </td>
                        <td class="fw-bold text-capitalize td-center">
                            {{ $value->position }}
                        </td>
                        <td class="fw-bold text-capitalize td-center">
                            {{ $value->role }}
                        </td>
                        <td class="fw-bold text-uppercase td-center">
                            {{ $value->from }}
                        </td>
                        <td class="td-center">
                            <button class="btn btn-link" onclick="resetPassword({{ $value->id }})">รีเซ็ต</button>
                        </td>
                        <td class="td-center">
                            <x-action-button id="{{$value->id}}" route="manage.users">

                            </x-action-button>
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
</x-section>
@endsection