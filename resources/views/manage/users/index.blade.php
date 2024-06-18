@extends('layouts.master', ['route' => url()->previous()])

@section('content')
<x-section>
    <x-slot name="title">
        <span class="material-symbols-rounded">
            group
        </span>
        ผู้ใช้งาน
    </x-slot>
    @can('create')
        <x-slot name="toolbar">
            <x-button type="a" label="เพิ่มผู้ใช้งาน" icon="add" color="primary" :href="route('manage.users.create')" />
        </x-slot>
    @endcan
    <x-search />
    <hr>
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
                    <th scope="col" class="text-center" width="9%"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="td-center">
                            <x-status :s="$user->status" />
                        </td>
                        <td class="align-middle">
                            {{ $user->name }}
                        </td>
                        <td class="align-middle">
                            {!! $user->email ?? '---' !!}
                        </td>
                        <td class="align-middle">
                            {{ $user->username }}
                        </td>
                        <td class="td-center">
                            {!! $user->contact_number ?? '---' !!}
                        </td>
                        <td class="td-center">
                            {!! $user->partner->name ?? '---' !!}
                        </td>
                        <td class="td-center">
                            {!! $user->department->name ?? '---' !!}
                        </td>
                        <td class="fw-bold text-capitalize td-center">
                            {{ $user->position }}
                        </td>
                        <td class="fw-bold text-capitalize td-center">
                            {{ $user->role }}
                        </td>
                        <td class="fw-bold text-uppercase td-center">
                            {{ $user->from }}
                        </td>
                        <td class="td-center">
                            <div class="hstack justify-content-evenly d-flex gap-1">
                                <!-- Custom-Button -->
                                @can('update', $user)
                                    <x-button tooltip="รีเซ็ตรหัสผ่าน" size="sm" icon="lock_reset" icon-size="20"
                                        color="secondary" :href="route('manage.users.reset-password', $user->id)" />
                                @endcan
                                <!-- Custom-Button -->
                                <!-- Action-Button -->
                                @can('view')
                                    <x-button tooltip="ดู" size="sm" icon="search" icon-size="20" color="info"
                                        :href="route('manage.users.show', $user->id)" />
                                @endcan
                                @can('update', $user)
                                    <x-button tooltip="แก้ไข" size="sm" icon="edit" icon-size="20" color="warning"
                                        :href="route('manage.users.edit', $user->id)" />
                                @endcan
                                @can('delete', $user)
                                    @if (!$user->deleted_at && $user->id !== auth()->id())
                                        <form method="POST" action="{{ route('manage.users.destroy', $user->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="submit" tooltip="ลบ" size="sm" icon="delete" icon-size="20"
                                                color="danger" />
                                        </form>
                                    @endif
                                @endcan
                                @can('restore')
                                    @if ($user->deleted_at && $user->id !== auth()->id())
                                        <form method="POST" action="{{ route('manage.users.restore') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$user->id}}" />
                                            <x-button type="submit" tooltip="คืนค่า" size="sm" icon="restart_alt" icon-size="20"
                                                color="success" />
                                        </form>
                                    @endif
                                @endcan
                                <!-- Action-Button -->
                            </div>
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
        {!! $users->appends($_GET)->links() !!}
    </div>
</x-section>
@endsection