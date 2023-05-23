@extends('layouts.master')

@section('title')
    <h3>Create {{ $title }}</h3>
@endsection

@section('content')
    <x-container cols="12" md="8" lg="6">
        <x-card>
            <x-form method="POST" action="{{ route($route . '.store') }}">
                @include("{$route}._form", $fields)
            </x-form>
        </x-card>
    </x-container>
@endsection
