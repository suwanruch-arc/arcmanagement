@extends('layouts.master')

@section('title')
    <h3>แก้ไข : {{ $title }}</h3>
@endsection

@section('content')
    <x-container :cols="$cols ?? 12" :md="$cols ?? 8" :lg="$cols ?? 6">
        <x-card>
            <x-form method="POST" action="{{ route($route . '.update', $params) }}">
                @method('PUT')
                @include("{$route}._form", $fields)
            </x-form>
        </x-card>
    </x-container>
@endsection
