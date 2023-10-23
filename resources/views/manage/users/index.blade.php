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
                        <th width="10%">Name</th>
                        <th width="10%">Email</th>
                        <th width="10%">Username</th>
                        <th width="10%">Contact Number</th>
                        <th width="10%">Partner</th>
                        <th width="10%">Department</th>
                        <th width="5%">Position</th>
                        <th width="5%">Role</th>
                        <th width="5%">From</th>
                        <th width="1%">Status</th>
                        <th width="9%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->username }}</td>
                            <td class="text-center">
                                {{ Str::mask($user->contact_number, '*', 7) }}
                            </td>
                            <td>
                                {!! $user->partner->name ?? '<i>ไม่ได้ตั้งค่า</i>' !!}
                            </td>
                            <td>
                                {!! $user->department->name ?? '<i>ไม่ได้ตั้งค่า</i>' !!}
                            </td>
                            <td class="fw-bold text-capitalize text-center">
                                {{ $user->position }}
                            </td>
                            <td class="fw-bold text-capitalize text-center">
                                {{ $user->role }}
                            </td>
                            <td class="fw-bold text-uppercase text-center">
                                {{ $user->from }}
                            </td>
                            <td class="text-center">
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
