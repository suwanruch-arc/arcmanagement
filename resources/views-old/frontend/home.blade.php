@extends('layouts.app')

@section('content')
    <div>
        <livewire:generate-qrcode />
        <livewire:generate-barcode />
    </div>
@endsection
