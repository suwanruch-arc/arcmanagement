@extends('layouts.master', [
    'breadcrumb' => [['url' => route('dashboard'), 'label' => 'แดชบอร์ด'], ['label' => 'ร้านค้า']],
])

@section('content')
    <x-section>
        <x-slot name="title">
            <span class="material-symbols-rounded">
                store
            </span>
            ร้านค้า
        </x-slot>
        <x-slot name="toolbar">
            @can('create')
                <x-button type="a" label="เพิ่มผู้ใช้งาน" icon="add" color="primary" :href="route('manage.shops.create')" />
            @endcan
        </x-slot>
        <div class="card">
            <div class="card-body">
                <x-search />
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-custom-font">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" width="1%">สถานะ</th>
                                <th scope="col" class="text-center" width="10%">ชื่อ</th>
                                <th scope="col" class="text-center" width="10%">คีย์เวิร์ด</th>
                                <th scope="col" class="text-center" width="5%">Template & Banner</th>
                                <th scope="col" class="text-center" width="7%">Terms and Conditions</th>
                                <th scope="col" class="text-center" width="9%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($shops as $shop)
                                <tr>
                                    <td class="td-center">
                                        <x-status :s="$shop->status" />
                                    </td>
                                    <td class="align-middle">
                                        {{ $shop->name }}
                                    </td>
                                    <td class="align-middle">
                                        {{ $shop->keyword }}
                                    </td>
                                    <td class="align-middle">
                                        
                                    </td>
                                    <td class="align-middle">
                                        
                                    </td>
                                    <td class="td-center">
                                        <div class="hstack justify-content-start d-flex gap-1 ">
                                            <!-- Custom-Button -->
                                            
                                            <!-- Custom-Button -->
                                            <!-- Action-Button -->
                                            @can('view')
                                                <x-button type="a" tooltip="ดู" size="sm" icon="search"
                                                    icon-size="20" color="info" :href="route('manage.users.show', $shop->id)" />
                                            @endcan
                                            @can('update', $shop)
                                                <x-button type="a" tooltip="แก้ไข" size="sm" icon="edit"
                                                    icon-size="20" color="warning" :href="route('manage.users.edit', $shop->id)" />
                                            @endcan
                                            @if ($shop->deleted_at)
                                                @can('restore')
                                                    @if ($shop->id !== auth()->id())
                                                        <form class="form-restore" method="POST"
                                                            action="{{ route('manage.users.restore') }}">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $shop->id }}" />
                                                            <x-button type="submit" tooltip="คืนค่า" size="sm"
                                                                icon="restart_alt" icon-size="20" color="success" />
                                                        </form>
                                                    @endif
                                                @endcan
                                            @else
                                                @can('delete', $shop)
                                                    @if ($shop->id !== auth()->id())
                                                        <form class="form-destroy" method="POST"
                                                            action="{{ route('manage.users.destroy', $shop->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <x-button type="submit" tooltip="ลบ" size="sm"
                                                                icon="delete" icon-size="20" color="danger" />
                                                        </form>
                                                    @endif
                                                @endcan
                                            @endif
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
                <div class="d-flex justify-content-between">
                    <span>จำนวนข้อมูล <strong class="initialism">{{ $shops->total() }}</strong> รายการ</span>
                    {!! $shops->appends($_GET)->links() !!}
                </div>
            </div>
        </div>
    </x-section>
@endsection
