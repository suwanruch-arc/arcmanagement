@extends('layouts.master')

@section('content')
    <x-section>
        <x-slot name="title">
            <span class="material-symbols-rounded">
                route
            </span>
            รายการเส้นทาง
        </x-slot>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>URI</th>
                                <th>Name</th>
                                <th>Action</th>
                                <th>Method</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($routes as $route)
                                <tr>
                                    <td>{!! preg_replace('/\{([^\}]+)\}/', '<b class="text-danger"><u><i>{$1}</i></u></b>', $route['uri']) !!}</td>
                                    <td>{{ $route['name'] }}</td>
                                    <td>{{ $route['action'] }}</td>
                                    <td>{{ implode(', ', $route['methods']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-section>
@endsection
