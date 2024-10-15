@extends('layouts.master', [
    'breadcrumb' => [['url' => route('dashboard'), 'label' => 'แดชบอร์ด'], ['label' => 'แคมเปญ']],
])

@section('content')
<x-section>
    <x-slot name="title">
        <span class="material-symbols-rounded">
            campaign
        </span>
        แคมเปญ
    </x-slot>
    <x-slot name="toolbar">
        @can('create')
            <x-button type="a" label="เพิ่มแคมเปญ" icon="add" color="primary" :href="route('site.campaigns.pre-create')" />
        @endcan
    </x-slot>
    <div class="card">
        <div class="card-body">
            <x-search />
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center" width="1%">Name</th>
                            <th scope="col" class="text-center" width="15%">Keyword</th>
                            <th scope="col" class="text-center" width="15%">Table Name</th>
                            <th scope="col" class="text-center" width="15%">Template Type</th>
                            <th scope="col" class="text-center" width="15%">Owner</th>
                            <th scope="col" class="text-center" width="15%">ระหว่างวันที่</th>
                            <th scope="col" class="text-center" width="15%">Status</th>
                            <th scope="col" class="text-center" width="9%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($campaigns as $campaign)
                            <tr>
                                <td class="td-center">
                                    <x-status :s="$campaign->status" />
                                </td>
                                <td class="align-middle">
                                    {{ $campaign->name }}
                                </td>
                                <td class="align-middle">
                                    {{ $campaign->keyword }}
                                </td>
                                <td class="align-middle">
                                    {{ $campaign->keyword }}
                                </td>
                                <td class="align-middle">
                                    {{ $campaign->keyword }}
                                </td>
                                <td class="align-middle">
                                    {{ $campaign->keyword }}
                                </td>
                                <td class="align-middle">
                                    {{ $campaign->keyword }}
                                </td>
                                <td class="td-center">
                                    <div class="hstack justify-content-start d-flex gap-1 ">
                                        <!-- Custom-Button -->

                                        <!-- Custom-Button -->
                                        <!-- Action-Button -->
                                        @can('view')
                                            <x-button type="a" tooltip="ดู" size="sm" icon="search" icon-size="20" color="info"
                                                :href="route('campaign.show', $campaign->id)" />
                                        @endcan
                                        @can('update', $campaign)
                                            <x-button type="a" tooltip="แก้ไข" size="sm" icon="edit" icon-size="20"
                                                color="warning" :href="route('campaign.edit', $campaign->id)" />
                                        @endcan
                                        @if ($campaign->deleted_at)
                                            @can('restore')
                                                <form class="form-restore" method="POST" action="{{ route('campaign.restore') }}">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $campaign->id }}" />
                                                    <x-button type="submit" tooltip="คืนค่า" size="sm" icon="restart_alt"
                                                        icon-size="20" color="success" />
                                                </form>
                                            @endcan
                                        @else
                                            @can('delete', $campaign)
                                                <form class="form-destroy" method="POST"
                                                    action="{{ route('campaign.destroy', $campaign->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-button type="submit" tooltip="ลบ" size="sm" icon="delete" icon-size="20"
                                                        color="danger" />
                                                </form>
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
                <span>จำนวนข้อมูล <strong class="initialism">{{ $campaigns->total() }}</strong> รายการ</span>
                {!! $campaigns->appends($_GET)->links() !!}
            </div>
        </div>
    </div>
</x-section>
@endsection