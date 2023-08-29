@extends('layouts.master')

@section('title')
    <h3>Warehouse - {{ $campaign->name }}</h3>
@endsection

@section('content')
    <x-container fluid>
        <div class="d-flex justify-content-end">
            <a href="{{ route('site.warehouse.import', $campaign->id) }}"
                class="text-bg-primary text-decoration-none rounded-top mx-2 px-3 py-1 fs-6">
                <span data-feather="upload"></span>&nbsp;นำเข้าข้อมูล
            </a>
        </div>
        <x-card>

        </x-card>
    </x-container>
@endsection
