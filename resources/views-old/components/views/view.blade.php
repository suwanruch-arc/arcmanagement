@extends('layouts.master', ['route' => url()->previous()])

@section('title')
    <h3>ข้อมูลของ {{ $title }}</h3>
@endsection

@section('content')
    <x-container :cols="$cols ?? 12" :md="$cols ?? 8" :lg="$cols ?? 6">
        <x-card>
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
        </x-card>
    </x-container>
@endsection
