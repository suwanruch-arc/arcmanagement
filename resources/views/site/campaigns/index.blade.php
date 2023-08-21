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
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($campaigns as $campaign)
                        <tr>
                            <td>{{ $campaign->name }}</td>
                            <td>{{ $campaign->keyword }}</td>
                            <td>{{ $campaign->template_type }}</td>
                            <td>{{ $campaign->owner->name }}</td>
                            <td class="text-center">
                                <x-action-btn route="site.campaigns" :params="['campaign' => $campaign->id]">
                                    <x-button color="info" class="m-1" href="/site/campaigns/{{$campaign->id}}/privileges">
                                        <small><span data-feather="layers"></span> Privileges</small>
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
