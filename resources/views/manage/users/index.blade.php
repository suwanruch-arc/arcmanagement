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
                        <th class="search">Name</th>
                        <th class="search">Email</th>
                        <th class="search">Username</th>
                        <th class="search">Contact Number</th>
                        <th class="search">Partner</th>
                        <th class="search">Department</th>
                        <th class="search">Position</th>
                        <th class="search">Role</th>
                        <th class="search">From</th>
                        <th width="1%">Status</th>
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
                            <td class="text-center align-middle">
                                {!! Status::show($user->status) !!}
                            </td>
                            <td class="text-center">
                                <x-action-btn :model="$user" route="manage.users" :params="['user' => $user->id]" />
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </x-datatable>
        </x-card>
    </x-container>
@endsection
