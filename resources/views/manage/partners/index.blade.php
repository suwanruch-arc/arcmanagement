@extends('layouts.master', [
    'breadcrumb' => [['url' => route('dashboard'), 'label' => 'แดชบอร์ด'], ['label' => 'พาร์ทเนอร์']],
])

@section('content')
    <x-section>
        <x-slot name="title">
            <span class="material-symbols-rounded">
                groups
            </span>
            พาร์ทเนอร์
        </x-slot>
        <x-slot name="toolbar">
            @can('create')
                <x-button type="a" label="เพิ่มพาร์ทเนอร์" icon="add" color="primary" :href="route('manage.partners.create')" />
            @endcan
        </x-slot>
        <div class="card">
            <div class="card-body">
                <x-search />
                <hr />
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" width="5%">สถานะ</th>
                                <th scope="col" class="text-center" width="38%">ชื่อ</th>
                                <th scope="col" class="text-center" width="38%">คีย์เวิร์ด</th>
                                <th scope="col" class="text-center" width="9%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($partners as $partner)
                                <tr class="table-secondary">
                                    <td></td>
                                    <td colspan="2" class="align-middle">
                                        <b>{{ $partner->name }}</b>
                                    </td>
                                    <td>
                                        <div class="hstack justify-content-start d-flex gap-1">
                                            <!-- Custom-Button -->
                                            @can('create')
                                                <x-button type="a" tooltip="เพิ่มดีพาร์ทเม้นท์" icon="add"
                                                    color="primary" size="sm" icon-size="20" :href="route(
                                                        'manage.partners.departments.create',
                                                        $partner->id,
                                                    )" />
                                            @endcan
                                            <!-- Custom-Button -->
                                            <!-- Action-Button -->
                                            @can('update', $partner)
                                                <x-button type="a" tooltip="แก้ไข" size="sm" icon="edit"
                                                    icon-size="20" color="warning" :href="route('manage.users.edit', $partner->id)" />
                                            @endcan
                                            @if ($partner->deleted_at)
                                                @can('restore')
                                                    <form class="form-restore" method="POST"
                                                        action="{{ route('manage.partners.restore') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $partner->id }}" />
                                                        <x-button type="submit" tooltip="คืนค่า" size="sm"
                                                            icon="restart_alt" icon-size="20" color="success" />
                                                    </form>
                                                @endcan
                                            @else
                                                @can('delete', $partner)
                                                    <form class="form-destroy" method="POST"
                                                        action="{{ route('manage.partners.destroy', $partner->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-button type="submit" tooltip="ลบ" size="sm" icon="delete"
                                                            icon-size="20" color="danger" />
                                                    </form>
                                                @endcan
                                            @endif
                                            <!-- Action-Button -->
                                        </div>
                                    </td>
                                </tr>
                                @forelse ($partner->departments as $department)
                                    <tr>
                                        <td class="td-center">
                                            <x-status :s="$department->status" />
                                        </td>
                                        <td class="align-middle">
                                            {{ $department->name }}
                                        </td>
                                        <td class="align-middle">
                                            {{ $department->keyword }}
                                        </td>
                                        <td>
                                            <div class="hstack justify-content-start d-flex gap-1">
                                                <!-- Custom-Button -->

                                                <!-- Custom-Button -->
                                                <!-- Action-Button -->
                                                @can('update', $department)
                                                    <x-button type="a" tooltip="แก้ไข" size="sm" icon="edit"
                                                        icon-size="20" color="warning" :href="route('manage.users.edit', $department->id)" />
                                                @endcan
                                                @if ($department->deleted_at)
                                                    @can('restore')
                                                        <form class="form-restore" method="POST"
                                                            action="{{ route('manage.partners.departments.restore') }}">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $department->id }}" />
                                                            <x-button type="submit" tooltip="คืนค่า" size="sm"
                                                                icon="restart_alt" icon-size="20" color="success" />
                                                        </form>
                                                    @endcan
                                                @else
                                                    @can('delete', $department)
                                                        <form class="form-destroy" method="POST"
                                                            action="{{ route('manage.partners.departments.destroy', ['partner' => $partner->id, 'department' => $department->id]) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <x-button type="submit" tooltip="ลบ" size="sm"
                                                                icon="delete" icon-size="20" color="danger" />
                                                        </form>
                                                    @endcan
                                                @endif
                                                <!-- Action-Button -->
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">ไม่มีข้อมูล</td>
                                    </tr>
                                @endforelse
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">ไม่มีข้อมูล</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-section>
@endsection
