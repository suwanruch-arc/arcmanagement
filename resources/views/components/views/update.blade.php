@extends('layouts.app', ['route' => url()->previous()])

@section('content')
    <x-container :cols="$cols ?? 12" :md="$cols ?? 8" :lg="$cols ?? 6">
        <x-card>
            <x-card-header>
                <div class="fs-5">
                    แก้ไข : {{ $title }}
                </div>
            </x-card-header>
            <x-card-body>
                <x-form method="POST" action="{{ route($route . '.update', $params) }}">
                    @method('PUT')
                    @include("{$route}._form", $fields)
                </x-form>
            </x-card-body>
        </x-card>
    </x-container>
@endsection
