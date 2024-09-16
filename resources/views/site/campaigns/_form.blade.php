@extends('layouts.master', [
    'prev_route' => url()->previous(),
    'breadcrumb' => [['url' => route('dashboard'), 'label' => 'แดชบอร์ด'], ['url' => route('campaigns.index'), 'label' => 'แคมเปญ'], ['url' => route('campaigns.pre-create'), 'label' => 'ประเภท ' . $template_type], empty($model) ? ['label' => 'เพิ่มแคมเปญ'] : ['label' => 'แก้ไข้ข้อมูล : ' . $model->name]],
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
                            </div>
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </x-section>
@endsection
