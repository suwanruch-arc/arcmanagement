@extends('layouts.master')

@section('title')
    <h3>Users</h3>
@endsection

@section('content')
    <x-container fluid>
        <x-header-btn justify="end" />
        <x-card>
            <x-datatable sort>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Contact Number</th>
                        <th>Partner</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Role</th>
                        <th>From</th>
                        <th>Status</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->contact_number }}</td>
                            <td>{{ $user->partner->name ?? '' }}</td>
                            <td>{{ $user->department->name ?? '' }}</td>
                            <td>{{ $user->position }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->from }}</td>
                            <td>{{ $user->status }}</td>
                            <td class="text-center">
                                <x-action-btn route="manage.users" :params="['user' => $user->id]" />
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </x-datatable>
        </x-card>
    </x-container>
@endsection
