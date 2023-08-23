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
                        <th>Default Code</th>
                        <th>Shop</th>
                        <th>Title</th>
                        <th>Value</th>
                        <th>Lot</th>
                        <th>Keyword</th>
                        <th>Status</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($privileges as $privilege)
                        <tr>
                            <td class="text-center align-middle">{{ strtoupper($privilege->default_code) }}</td>
                            <td class="align-middle">{{ $privilege->shop->name }}</td>
                            <td class="align-middle">{{ $privilege->title }}</td>
                            <td class="align-middle">{{ $privilege->value }} ฿</td>
                            <td class="align-middle">{{ $privilege->lot }}</td>
                            <td class="align-middle">{{ $privilege->keyword }}</td>
                            <td class="align-middle">{{ $privilege->status }}</td>
                            <td class="text-center align-middle">
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
