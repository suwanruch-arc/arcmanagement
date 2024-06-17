@extends('layouts.master')

@section('content')
<x-section>
    <x-slot name="title">
        Dashboard
    </x-slot>
    <div>
        @for ($i = 1; $i <= 1; $i++)
            test <Br>
        @endfor
    </div>
</x-section>
@endsection