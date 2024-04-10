@extends('layouts.app', ['route' => url()->previous()])

@section('title')
    <h3>ข้อมูลของ {{ $title }}</h3>
@endsection

@section('content')
    <x-container :cols="$cols ?? 12" :md="$cols ?? 8" :lg="$cols ?? 6">
        <x-card>
            <x-card-body>
                <table class="table table-bordered">
                    <tbody>
                        @foreach ($data as $field => $value)
                            <tr>
                                <th>{{ ucwords($field) }}</th>
                                <td>{{ $value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-card-body>
        </x-card>
    </x-container>
@endsection
