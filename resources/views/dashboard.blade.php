@extends('layouts.master')

@section('title')
    <h4>Dashboard</h4>
@endsection

@section('content')
    <div class="row row-cols-1 row-cols-md-2">
        <div class="col-xl-3 col-sm-6 col-12">
            <x-info-box label="Campaigns" icon="archive" value="200" />
        </div>
    </div>
@endsection
