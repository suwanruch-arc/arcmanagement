@extends('layouts.master', ['route' => url()->previous()])

@section('title')
    <h3>Partner</h3>
@endsection
{{-- @php
    dd(get_defined_vars());
@endphp --}}
@section('content')
    <x-container fluid>
        <x-card>
            <x-card.body>
                <div class="d-flex justify-content-between">
                    <div class="fs-5">
                        Partner / Department
                    </div>
                    <x-button label="เพิ่ม Partner" icon="add" color="outline-secondary" size="sm" :href="route('manage.partners.create')" />
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
                                <th width="5%">Status</th>
                                <th width="45%">Name</th>
                                <th width="45%">Keyword</th>
                                <th width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($partners as $partner)
                                <tr class="bg-secondary bg-opacity-10">
                                    <td class="text-center">
                                        {!! Status::show($partner->status) !!}
                                    </td>
                                    <td class="align-middle">
                                        <b>{{ $partner->name }}</b>
                                    </td>
                                    <td class="align-middle">
                                        {{ $partner->keyword }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <x-action-btn :model="$partner" route="manage.partners" :params="['partner' => $partner->id]">
                                            <x-button class="m-1  btn-sm" label="เพิ่ม" :href="route('manage.partners.departments.create', [
                                                'partner' => $partner->id,
                                            ])">
                                                <span class="material-icons-round fs-5">add</span>
                                            </x-button>
                                        </x-action-btn>
                                    </td>
                                </tr>
                                @forelse ($partner->departments as $department)
                                    <tr>
                                        <td class="text-center">
                                            {!! Status::show($department->status) !!}
                                        </td>
                                        <td class="align-middle">
                                            {!! Image::show($department->id, $department->getTable(), [
                                                'id' => 'logo',
                                                'width' => '100px',
                                                'class' => 'img-thumbnail rounded p-1',
                                            ]) !!}
                                            {{ $department->name }}
                                            <i><small>{{ $department->is_main === 'yes' ? '(Main)' : '' }}</small></i>
                                        </td>
                                        <td class="align-middle">
                                            {{ $department->keyword }}
                                        </td>
                                        <td class="text-center">
                                            <x-action-btn :model="$department" route="manage.partners.departments"
                                                :params="['partner' => $partner->id, 'department' => $department->id]" />
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card.body>
        </x-card>
    </x-container>
@endsection
