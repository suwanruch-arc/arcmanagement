@extends('layouts.master')

@section('title')
    <h3>Partner</h3>
@endsection
{{-- @php
    dd(get_defined_vars());
@endphp --}}
@section('content')
    <x-container fluid>
        <x-header-btn justify="end" />
        <x-card>
            <x-datatable>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th width="25%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($partners as $partner)
                        <tr>
                            <td class="align-middle bg-light">
                                <b>{{ $partner->name }}</b>
                            </td>
                            <td class="text-center align-middle bg-light">
                                <x-action-btn :disable="$partner->status" route="manage.partners" :params="['partner' => $partner->id]">
                                    <x-button :href="route('manage.partners.departments.create', ['partner' => $partner->id])">
                                        <b data-feather="plus"></b>
                                    </x-button>
                                </x-action-btn>
                            </td>
                        </tr>
                        @forelse ($partner->departments as $department)
                            <tr>
                                <td class="align-middle">
                                    {!! Image::show($department->id, $department->getTable(), [
                                        'id' => 'logo',
                                        'width' => '100px',
                                        'class' => 'img-thumbnail rounded p-1',
                                    ]) !!}
                                    {{ $department->name }}
                                </td>
                                <td class="text-center">
                                    <x-action-btn :disable="$department->status" route="manage.partners.departments" :params="['partner' => $partner->id, 'department' => $department->id]" />
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    @empty
                    @endforelse
                </tbody>
            </x-datatable>
        </x-card>
    </x-container>
@endsection
