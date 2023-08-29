@extends('layouts.master')

@section('title')
    <h3>Campaigns</h3>
@endsection

@section('content')
    <x-container fluid>
        <x-header-btn justify="end" />
        <x-card>
            <x-datatable sort>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Keyword</th>
                        <th>Template Type</th>
                        <th>Owner</th>
                        <th class="no-search" width="1%">Status</th>
                        <th class="no-search" width="1%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($campaigns as $campaign)
                        <tr>
                            <td>{{ $campaign->name }}</td>
                            <td>{{ $campaign->keyword }}</td>
                            <td>{{ $campaign->template_type }}</td>
                            <td>{{ $campaign->owner->name }}</td>
                            <td class="text-center align-middle">
                                {!! Status::show($campaign->status) !!}
                            </td>
                            <td class="text-center">
                                <x-action-btn :disable="$campaign->status" route="site.campaigns" :params="['campaign' => $campaign->id]">
                                    <x-button color="secondary"
                                        href="{{ route('site.warehouse.index', $campaign->id) }}"
                                        class="m-1 text-nowrap">
                                        <span data-feather="upload"></span>&nbsp;นำเข้าข้อมูล
                                    </x-button>
                                    <x-button color="info" class="m-1 text-nowrap"
                                        href="{{ route('site.campaigns.privileges.index', $campaign->id) }}">
                                        <span data-feather="layers"></span>&nbsp;Privileges
                                    </x-button>
                                </x-action-btn>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </x-datatable>
        </x-card>
    </x-container>
@endsection
