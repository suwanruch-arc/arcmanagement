@extends('layouts.master', [
    'prev_route' => url()->previous(),
    'breadcrumb' => [['url' => route('dashboard'), 'label' => 'แดชบอร์ด'], ['url' => route('manage.users.index'), 'label' => 'ผู้ใช้งาน'], empty($model) ? ['label' => 'เพิ่มผู้ใช้งาน'] : ['label' => 'แก้ไข้ข้อมูล : ' . $model->name]],
])

@section('content')
    <x-section>
        <x-slot name="title">
            @if (isset($model))
                <span class="material-symbols-rounded">
                    person_edit
                </span>
                แก้ไขผู้ใช้งาน : {{ $model->name }}
            @else
                <span class="material-symbols-rounded">
                    person_add
                </span>
                เพิ่มผู้ใช้งาน
            @endif
        </x-slot>
        <div class="container d-flex justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <x-form
                            :model="$model"
                            route="manage.users"
                            :params="$model->id ?? null"
                        >
                            <div class="row row-cols-1 row-cols-md-2">
                                <div class="col">
                                    <x-input
                                        placeholder="ชื่อ - นามสกุล"
                                        label="ชื่อ"
                                        name="name"
                                        required
                                    />
                                </div>
                                <div class="col">
                                    <x-input
                                        placeholder="example@mail.com"
                                        label="อีเมล"
                                        name="email"
                                        required
                                    />
                                </div>
                            </div>
                            @if (is_null($model))
                                <div class="row row-cols-1 row-cols-md-2">
                                    <div class="col">
                                        <x-input
                                            placeholder="username"
                                            label="ชื่อผู้ใช้งาน"
                                            name="username"
                                            :value="old('username') ?? null"
                                            required
                                        />
                                    </div>
                                    <div class="col">
                                        <x-input
                                            placeholder="password"
                                            type="password"
                                            label="รหัสผ่าน"
                                            name="password"
                                            required
                                        />
                                    </div>
                                </div>
                            @endif
                            <x-select
                                name="category_id"
                                :options="[
                                    1 => 'Category 1',
                                    2 => 'Category 2',
                                    3 => 'Category 3',
                                ]"
                                selected="{{ old('category_id') }}"
                                placeholder="Select a Category"
                                class="form-select"
                            />
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </x-section>
@endsection
