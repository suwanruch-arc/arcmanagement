@extends('layouts.master')

@section('title')
    <h3>Reports</h3>
@endsection

@section('content')
    <x-container fluid>
        <x-header-btn justify="end" />
        <x-card>
            <x-datatable sort>
                <thead>
                    <tr>
                        <th>UUID</th>
                        <th>Name</th>
                        <th class="no-search" width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $report)
                        <tr>
                            <td>{{ $report->uuid }}</td>
                            <td>{{ $report->name }}</td>
                            <td class="text-center">
                                <x-action-btn route="manage.reports" :params="['report' => $report->id]">
                                    <x-button class="m-1" type="button"
                                        href="{{ route('site.reports.show', $report->uuid) }}" color="info">
                                        <i data-feather="eye"></i>
                                    </x-button>
                                </x-action-btn>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </x-datatable>
        </x-card>
    </x-container>
@endsection
