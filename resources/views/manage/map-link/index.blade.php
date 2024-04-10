@extends('layouts.app', ['route' => url()->previous()])

@section('content')
    <x-container>
        <div class="row">
            <div class="col-12">
                <x-card>
                    <x-card-body>
                        <x-select select2 label="กรุณาเลือกแคมเปญที่ต้องการ Map Link" name="select-campaign" :src="['active' => 'ใช้งาน', 'inactive' => 'ไม่ใช้งาน']"
                            required />
                    </x-card-body>
                </x-card>
            </div>
        </div>
    </x-container>
@endsection
