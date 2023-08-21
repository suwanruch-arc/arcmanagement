@extends('layouts.master')

@section('title')
    <h3>{{ $campaign->name }} - Privileges</h3>
@endsection

@section('content')
    <x-container fluid>
        <x-header-btn justify="end" />
        <x-card>
            <x-datatable sort>
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Default Code</th>
                        <th>Shop</th>
                        <th>Title</th>
                        <th>Value</th>
                        <th>Lot</th>
                        <th>Keyword</th>
                        <th>Description</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($privileges as $privilege)
                        <tr>
                            <td>{{ $privilege->name }}</td>
                            <td>{{ $privilege->name }}</td>
                            <td>{{ $privilege->name }}</td>
                            <td>{{ $privilege->name }}</td>
                            <td>{{ $privilege->name }}</td>
                            <td>{{ $privilege->name }}</td>
                            <td>{{ $privilege->name }}</td>
                            <td>{{ $privilege->name }}</td>
                            <td class="text-center">
                                <x-action-btn route="site.campaigns.privileges" :params="['campaign' => $privilege->campaign->id, 'privilege' => $privilege->id]" />
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </x-datatable>
        </x-card>
    </x-container>
@endsection
