@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="four_zero_four_bg">
        </div>
        <h1>404 Not Found</h1>
        <p>The page you are looking for could not be found.</p>
        <p>Please check the URL or go back</p>
        <a class="btn btn-primary" href="{{ url()->previous() }}" class="button"><b class="material-icons-round fs-5">arrow_back_ios</b> Go Back</a>
        <a class="btn btn-secondary" href="/"><b class="material-icons-round">home</b> homepage</a>
    </div>
@endsection

@section('css')
    <style>
        #sidebarMenu {
            display: none !important;
        }

        .four_zero_four_bg {

            background-image: url({{ asset('imgs/stone_human.gif') }});
            height: 400px;
            background-position: center;
        }

        main {
            margin: auto !important;
        }
    </style>
@endsection
