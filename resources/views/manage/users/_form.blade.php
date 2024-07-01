@extends('layouts.master', [
    'prev_route' => url()->previous(),
    'breadcrumb' => [['url' => route('dashboard'), 'label' => 'แดชบอร์ด'], ['url' => route('manage.users.index'), 'label' => 'ผู้ใช้งาน'], empty($model) ? ['label' => 'เพิ่มผู้ใช้งาน'] : ['label' => 'แก้ไข้ข้อมูล : ' . $model->name]],
])

@section('content')
    <x-section>
        <x-slot name="title">
            @if (isset($model))
                <span class="material-symbols-rounded">
                    edit
                </span>
                แก้ไขข้อมูล : {{ $model->name }}
            @else
                <span class="material-symbols-rounded">
                    add
                </span>
                เพิ่มผู้ใช้งาน
            @endif
        </x-slot>
        <div class="container d-flex justify-content-center">
            <div class="col-md-12 col-lg-10 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <x-form :model="$model" route="manage.users" :params="$model->id ?? null">
                            <div class="row row-cols-1 row-cols-md-2">
                                <div class="col">
                                    <x-input.text placeholder="ชื่อ - นามสกุล" label="ชื่อ" name="name"
                                        :value="old('name') ?? ($model->name ?? null)" required />
                                </div>
                                <div class="col">
                                    <x-input.text placeholder="example@mail.com" label="อีเมล" name="email"
                                        type="email" :value="old('email') ?? ($model->email ?? null)" required />
                                </div>
                                <div class="col">
                                    <x-input.text placeholder="091-888-8888" label="เบอร์โทรศัพท์" name="contact_number"
                                        type="tel" :value="old('contact_number') ?? ($model->contact_number ?? null)" required />
                                </div>
                                <div class="col">
                                    <x-input.select class="select2" label="พาร์ทเนอร์" name="department_id"
                                        :options="$partner_lists"
                                        selected="{{ old('department_id') ?? ($model->department_id ?? null) }}" required/>
                                </div>
                            </div>
                            @if (is_null($model))
                                <div class="row row-cols-1 row-cols-md-2">
                                    <div class="col">
                                        <x-input.text autocomplete="off" placeholder="username" label="ชื่อผู้ใช้งาน"
                                            name="username" :value="old('username') ?? null" required />
                                    </div>
                                    <div class="col">
                                        <x-input.text autocomplete="off" placeholder="password" type="password"
                                            label="รหัสผ่าน" name="password" required />
                                    </div>
                                </div>
                            @endif
                            <div class="row row-cols-1 row-cols-md-2">
                                <div class="col">
                                    <x-input.select label="ตำแหน่ง" name="position" :options="['admin' => 'Admin', 'leader' => 'Leader', 'employee' => 'Employee']"
                                        selected="{{ old('position') ?? ($model->position ?? 'employee') }}"
                                        placeholder="กรุณาเลือกตำแหน่ง" class="select2" />
                                </div>
                                <div class="col">
                                    <x-input.select label="สิทธิ์" name="role" :options="['admin' => 'Admin', 'moderator' => 'Moderator', 'user' => 'User']"
                                        selected="{{ old('role') ?? ($model->role ?? 'user') }}"
                                        placeholder="กรุณาเลือกสิทธิ์" class="select2" />
                                </div>
                            </div>
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </x-section>
@endsection
