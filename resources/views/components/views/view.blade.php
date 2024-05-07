@extends('layouts.master', ['route' => url()->previous()])

@section('content')
    <x-container :cols="$cols ?? 12" :md="$cols ?? 8" :lg="$cols ?? 6">
        <x-card>
            {{-- <x-card-header class="d-flex align-item-center justify-content-between">
                <div class="fs-5">
                    ข้อมูลของ {{ $title }}
                </div>
            </x-card-header> --}}
            <x-card-body>
                <div class="fs-5">
                    ข้อมูลของ {{ $title }}
                </div>
                <hr />
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
