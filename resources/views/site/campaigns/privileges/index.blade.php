@extends('layouts.app', ['route' => route('site.campaigns.index')])

@section('title')
    <a class="btn btn-sm btn-outline-secondary mb-2" href="{{ route('site.warehouse.index', $campaign->id) }}">
        <b class="material-icons-round fs-5">upload</b> นำเข้าข้อมูล
    </a>
    <h3>

        <br> {{ $campaign->name }} - Privileges
    </h3>
@endsection

@section('content')
    <x-container fluid>
        <div class="d-flex justify-content-end">
            <a href="{{ route('site.campaigns.privileges.create', $campaign->id) }}"
                class="text-bg-primary text-decoration-none rounded-top mx-2 ps-2 pe-3 py-1 fs-6"><span
                    class="material-icons-round">add</span>
                เพิ่ม</a>
        </div>
        <x-card>
            <x-card-body>
                <x-datatable sort>
                    <thead>
                        <tr>
                            <th width="1%">Default Code</th>
                            @switch($campaign->template_type)
                                @case('STD')
                                    <th width="1%">Banner</th>
                                @break

                                @case('CTMT')
                                    <th width="1%">Template</th>
                                @break
                            @endswitch
                            <th width="25%">Shop</th>
                            <th width="25%">Title</th>
                            <th width="1%">Value</th>
                            <th width="15%">Start Date</th>
                            <th width="15%">End Date</th>
                            <th width="3%">Lot</th>
                            <th width="1%">Keyword</th>
                            <th width="1%">Status</th>
                            <th width="1%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($privileges as $privilege)
                            <tr>
                                <td class="text-center align-middle">{{ strtoupper($privilege->default_code) }}</td>
                                <td class="text-center">
                                    @switch($campaign->template_type)
                                        @case('STD')
                                            {!! Image::show($privilege->id, 'privileges', [
                                                'id' => 'banner',
                                                'width' => '100px',
                                                'class' => 'img-thumbnail rounded p-1 img-preview',
                                            ]) !!}
                                        @break

                                        @case('CTMT')
                                            {!! Image::show($privilege->id, 'privileges', [
                                                'id' => 'template',
                                                'width' => '100px',
                                                'class' => 'img-thumbnail rounded p-1 img-preview',
                                            ]) !!}
                                        @break
                                    @endswitch
                                </td>
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
                                    <x-action-btn :model="$privilege" route="site.campaigns.privileges" :params="['campaign' => $privilege->campaign->id, 'privilege' => $privilege->id]" />
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </x-datatable>
                </x-card-body>
            </x-card>
        </x-container>
    @endsection
