@extends('layouts.master', [
    'prev_route' => url()->previous(),
    'breadcrumb' => [['url' => route('dashboard'), 'label' => 'แดชบอร์ด'], ['url' => route('campaigns.index'), 'label' => 'แคมเปญ'], ['label' => 'เลือกประเภท']],
])

@section('content')
    <x-section>
        <x-slot name="title">
            <span class="material-symbols-rounded">
                list
            </span>
            เลือกประเภท - แคมเปญ
        </x-slot>
        <div class="container d-flex justify-content-center">
            <div class="col-md-12 col-lg-10 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('campaigns.create') }}" method="GET">
                            <div class="row row-cols-1 row-cols-md-2">
                                <div class="col">
                                    <x-input.select label="ประเภทแคมเปญ" name="template_type" :options="[
                                        'STD' => '[STD] Standard Template',
                                        'CTMT' => '[CTMT] Customize Template',
                                        'CTMS' => '[CTMS] Customize System',
                                    ]"
                                        :selected="request('template_type') ?? null" required />
                                </div>
                                <div class="col">
                                    <x-input.select label="ผู้ดูแล" name="owner_id" :options="$partner_lists"
                                        :selected="old('owner_id') ?? (request('owner_id') ?? null)" class="select2"
                                        required />
                                </div>
                            </div>
                            <hr>
                            <div>
                                <x-button type="submit" label="ถัดไป" icon="arrow_forward" color="success" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-section>
@endsection
