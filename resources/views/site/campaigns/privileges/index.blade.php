@extends('layouts.master')

@section('title')
    <h3><a class="btn btn-sm btn-outline-secondary mb-2" href="{{ route('site.campaigns.index') }}">
            <i data-feather="chevrons-left"></i>ย้อนกลับ
        </a>
        <br> {{ $campaign->name }} - Privileges
    </h3>
@endsection

@section('content')
    <x-container fluid>
        <x-header-btn justify="end" />
        <x-card>
            <x-datatable sort>
                <thead>
                    <tr>
                        <th width="1%">Default Code</th>
                        <th width="25%">Shop</th>
                        <th width="25%">Title</th>
                        <th width="1%">Value</th>
                        <th width="15%">Start Date</th>
                        <th width="15%">End Date</th>
                        <th width="3%">Lot</th>
                        <th width="1%">Keyword</th>
                        <th class="no-search" width="1%">Status</th>
                        <th class="no-search" width="1%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($privileges as $privilege)
                        <tr>
                            <td class="text-center align-middle">{{ strtoupper($privilege->default_code) }}</td>
                            <td class="align-middle">{{ $privilege->shop->name }}</td>
                            <td class="align-middle">{{ $privilege->title }}</td>
                            <td class="text-end align-middle">{{ number_format($privilege->value, 0) }} ฿</td>
                            <td class="text-center align-middle fw-bold">{{ $privilege->start_date }}</td>
                            <td class="text-center align-middle fw-bold">{{ $privilege->end_date }}</td>
                            <td class="text-center align-middle">{{ $privilege->lot }}</td>
                            <td class="text-center align-middle">{{ $privilege->keyword }}</td>
                            <td class="text-center align-middle">
                                {!! Status::show($privilege->status) !!}
                            </td>
                            <td class="text-center align-middle">
                                <x-action-btn :disable="$privilege->status" route="site.campaigns.privileges" :params="['campaign' => $privilege->campaign->id, 'privilege' => $privilege->id]" />
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </x-datatable>
        </x-card>
    </x-container>
@endsection
