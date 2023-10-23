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
                        <th class="search">Name</th>
                        <th class="search">Keyword</th>
                        <th class="search">Table Name</th>
                        <th class="search">Template Type</th>
                        <th class="search">Owner</th>
                        <th width="1%">Status</th>
                        <th width="1%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($campaigns as $campaign)
                        <tr>
                            <td>{{ $campaign->name }}</td>
                            <td>{{ $campaign->keyword }}</td>
                            <td>{{ $campaign->table_name }}</td>
                            <td>{{ $campaign->template_type }}</td>
                            <td>{{ $campaign->owner->name }}</td>
                            <td class="text-center align-middle">
                                {!! Status::show($campaign->status) !!}
                            </td>
                            <td class="text-center">
                                <x-action-btn :model="$campaign" route="site.campaigns" :params="['campaign' => $campaign->id]">
                                    <x-button color="secondary"
                                        href="{{ route('site.warehouse.index', $campaign->id) }}"
                                        class="m-1 text-nowrap">
                                        <span data-feather="archive"></span>&nbsp;คลังข้อมูล
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
