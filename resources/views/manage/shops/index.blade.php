@extends('layouts.master')

@section('title')
    <h3>Shops</h3>
@endsection

@section('content')
    <x-container fluid>
        <x-header-btn justify="end" />
        <x-card>
            <x-datatable sort>
                <thead>
                    <tr>
                        <th class="search" width="15%">Name</th>
                        <th class="search" width="15%">Keyword</th>
                        <th width="15%">Template</th>
                        <th width="15%">Banner</th>
                        <th width="30%">Terms and Conditions</th>
                        <th width="1%">Status</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shops as $shop)
                        <tr>
                            <td>{{ $shop->name }}</td>
                            <td>{{ $shop->keyword }}</td>
                            <td class="text-center">
                                {!! Image::show($shop->id, 'shops', [
                                    'id' => 'template',
                                    'width' => '100px',
                                    'class' => 'img-thumbnail rounded p-1',
                                ]) !!}
                            </td>
                            <td class="text-center">
                                {!! Image::show($shop->id, 'shops', [
                                    'id' => 'banner',
                                    'width' => '100px',
                                    'class' => 'img-thumbnail rounded p-1',
                                    ]) !!}
                            </td>
                            <td>
                                <button class="btn btn-link" onclick="showTandC('{!! $shop->tandc !!}')">แสดง</button>
                            </td>
                            <td class="text-center align-middle">
                                {!! Status::show($shop->status) !!}
                            </td>
                            <td class="text-center">
                                <x-action-btn :disable="$shop->status" route="manage.shops" :params="['shop' => $shop->id]" />
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </x-datatable>
        </x-card>
    </x-container>
@endsection
