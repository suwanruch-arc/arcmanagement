@extends('layouts.master', ['route' => url()->previous()])

@section('content')
    <x-container>
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-12">
                <x-card>
                    <x-card-header>
                        <div class="fs-5">
                            สร้าง แคมเปญ - 1/2
                        </div>
                    </x-card-header>
                    <x-card-body>
                        <form action="{{ route('site.campaigns.create') }}" method="GET">
                            <div class="row row-cols-1 row-cols-md-2">
                                <div class="col">
                                    <x-select select2 label="ประเภทแคมเปญ" name="template_type" :src="[
                                        'STD' => '[STD] Standard Template',
                                        'CTMT' => '[CTMT] Customize Template',
                                        'CTMS' => '[CTMS] Customize System',
                                    ]" required
                                        value="" />
                                </div>
                                <div class="col">
                                    <x-select label="ผู้ดูแล" name="owner_id" :src="$owner_lists" value="" required />
                                </div>
                            </div>
                            <button class="btn btn-primary mt-3" type="submit"><i
                                    class="material-icons-round">arrow_forward</i> ต่อไป</button>
                        </form>
                    </x-card-body>
                </x-card>
            </div>
        </div>
    </x-container>
@endsection
