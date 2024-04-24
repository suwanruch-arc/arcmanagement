@extends('layouts.master')

@section('content')
    <x-container fluid>
        <x-card>
            <x-card.header class="fs-5 justify-content-between pe-2">
                <div class="">
                    <span class="material-icons-round ">
                        handyman
                    </span>
                    เครื่องมือสร้างข้อมูล
                </div>
                <div class="">
                    <x-button label="อัปโหลดไฟล์" icon="upload" :href="route('manage.tools.upload')" />
                </div>
            </x-card.header>
            <x-card.body>
                {{print_r($columns)}}
                {{-- <x-table :columns="$columns"/> --}}
            </x-card.body>
        </x-card>
    </x-container>
@endsection

@section('js')
    <script></script>
@endsection
