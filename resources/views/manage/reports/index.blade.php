@extends('layouts.master', ['route' => url()->previous()])

@section('title')
    <h3>Reports</h3>
@endsection

@section('content')
    <x-container fluid>
        <x-card>
            <x-card-header class="d-flex align-item-center justify-content-between">
                <div class="fs-5">
                    รายงาน
                </div>
                <x-header-btn justify="end" />
            </x-card-header>
            <x-card-body>
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
                                    <x-action-btn :model="$report" route="manage.reports" :params="['report' => $report->id]">
                                        <x-button label="ดู Report" class="m-1 btn-sm" type="button"
                                            href="{{ route('site.reports.show', $report->uuid) }}" color="info">
                                            <i class="material-icons-round fs-5">visibility</i>
                                        </x-button>
                                    </x-action-btn>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </x-datatable>
            </x-card-body>
        </x-card>
    </x-container>
@endsection
