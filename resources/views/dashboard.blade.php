@extends('layouts.master')

@section('title')
    <h4>Dashboard</h4>
@endsection

@section('content')
    <div class="row row-cols-1 row-cols-md-2">
        <div class="col-xl-3 col-sm-6 col-12">
            <x-info-box label="Campaigns" icon="archive" :value="$total_campaign" />
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <x-info-box label="Total Code" icon="terminal" :value="$total_code" />
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <x-info-box label="Total Use" icon="code" :value="$total_use" />
        </div>
    </div>
@endsection
