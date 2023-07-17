@extends('layouts.master')

@section('title')
    <h3>Reports</h3>
@endsection

@section('content')
    <x-container fluid>
        <x-card>
            <div>
                @includeIf('manage.reports.show-search', ['settings' => $report->settings ?? []])
            </div>
            <div>
                <x-datatable class="table table-bordered " width="100%">
                    <thead>
                        <tr>
                            @foreach ($report->settings as $setting)
                                <th>
                                    {{ $setting->label }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($results as $result)
                            <tr>
                                @foreach ($report->settings as $setting)
                                    <td>
                                        {{ $result[$setting->field] }}
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr colspan="{{ count($report->settings) }}">
                                <td>No Has Data...</td>
                            </tr>
                        @endforelse
                    </tbody>
                </x-datatable>
            </div>
        </x-card>
    </x-container>
@endsection

@section('js')
@endsection
