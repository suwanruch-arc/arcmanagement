@extends('layouts.master')

@section('title')
    <h3><a class="btn btn-sm btn-outline-secondary mb-2" href="{{ route('site.campaigns.index') }}">
            <i data-feather="chevrons-left"></i> ย้อนกลับ
        </a>&nbsp;<a class="btn btn-sm btn-outline-secondary mb-2" href="{{ route('site.warehouse.index', $campaign->id) }}">
            <i data-feather="upload"></i> นำเข้าข้อมูล
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
                        <th class="search" width="1%">Default Code</th>
                        @switch($campaign->template_type)
                            @case('STD')
                                <th class="search" width="1%">Banner</th>
                            @break

                            @case('CTM')
                                <th class="search" width="1%">Template</th>
                            @break
                        @endswitch
                        <th class="search" width="25%">Shop</th>
                        <th class="search" width="25%">Title</th>
                        <th class="search" width="1%">Value</th>
                        <th class="search" width="15%">Start Date</th>
                        <th class="search" width="15%">End Date</th>
                        <th class="search" width="3%">Lot</th>
                        <th class="search" width="1%">Keyword</th>
                        <th width="1%">Status</th>
                        <th width="1%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($privileges as $privilege)
                        <tr>
                            <td class="text-center align-middle">{{ strtoupper($privilege->default_code) }}</td>

                            @switch($campaign->template_type)
                                @case('STD')
                                    <td class="text-center">
                                        {!! Image::show($privilege->id, 'privileges', [
                                            'id' => 'banner',
                                            'width' => '100px',
                                            'class' => 'img-thumbnail rounded p-1 img-preview',
                                        ]) !!}
                                    </td>
                                @break

                                @case('CTM')
                                    <td class="text-center">
                                        {!! Image::show($privilege->id, 'privileges', [
                                            'id' => 'template',
                                            'width' => '100px',
                                            'class' => 'img-thumbnail rounded p-1 img-preview',
                                        ]) !!}
                                    </td>
                                @break
                            @endswitch

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
