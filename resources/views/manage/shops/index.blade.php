@extends('layouts.master', ['route' => url()->previous()])

@section('content')
    <x-container fluid>
        <x-card>
            <x-card.body>
                <div class="d-flex justify-content-between">
                    <div class="fs-5">
                        ร้านค้า
                    </div>
                    <x-button label="เพิ่มร้านค้า" icon="add" color="outline-secondary" size="sm" :href="route('manage.shops.create')" />
                </div>
                <hr />
                <form class="mb-3 d-flex gap-2">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search" placeholder="ค้นหาข้อมูล"
                            value="{{ $_GET['search'] ?? '' }}" />
                        <button class="btn btn-primary" type="submit" id="search-btn">
                            ค้นหา
                        </button>
                    </div>
                    @if (isset($_GET['search']))
                        <button class="btn btn-outline-secondary" type="button" id="clear-btn"
                            onclick="window.location = window.location.href.split('?')[0]">
                            ล้าง
                        </button>
                    @endif
                </form>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th width="1%">Status</th>
                                <th width="15%">Name</th>
                                <th width="15%">Keyword</th>
                                <th width="15%">Template</th>
                                <th width="15%">Banner</th>
                                <th width="30%">Terms and Conditions</th>
                                <th width="15%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $value)
                                <tr>
                                    <td class="text-center align-middle">
                                        {!! Status::show($value->status) !!}
                                    </td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->keyword }}</td>
                                    <td class="text-center">
                                        {!! Image::show($value->id, 'shops', [
                                            'id' => 'template',
                                            'width' => '100px',
                                            'class' => 'img-thumbnail rounded p-1',
                                        ]) !!}
                                    </td>
                                    <td class="text-center">
                                        {!! Image::show($value->id, 'shops', [
                                            'id' => 'banner',
                                            'width' => '100px',
                                            'class' => 'img-thumbnail rounded p-1',
                                        ]) !!}
                                    </td>
                                    <td>
                                        <button class="btn btn-link"
                                            onclick="showTandC('{!! $value->tandc !!}')">แสดง</button>
                                    </td>
                                    <td class="text-center">
                                        <x-action-btn :model="$value" route="manage.shops" :params="['shop' => $value->id]" />
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
                <div class="d-flex justify-content-end">
                    {!! $data->links() !!}
                </div>
            </x-card.body>
        </x-card>
    </x-container>
@endsection
