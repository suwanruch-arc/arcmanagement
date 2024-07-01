@extends('layouts.master', [
    'prev_route' => url()->previous(),
    'breadcrumb' => [['url' => route('dashboard'), 'label' => 'แดชบอร์ด'], ['url' => route('manage.partners.index'), 'label' => 'พาร์ทเนอร์'], empty($model) ? ['label' => 'เพิ่มพาร์ทเนอร์'] : ['label' => 'แก้ไข้ข้อมูล : ' . $model->name]],
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
                เพิ่มพาร์ทเนอร์
            @endif
        </x-slot>
        <div class="container d-flex justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <x-form :model="$model" route="manage.partners" :params="$model->id ?? null">
                            <div class="row row-cols-1 row-cols-md-2">
                                <div class="col">
                                    <x-input.text placeholder="ชื่อ" label="พาร์ทเนอร์" name="partner_name"
                                        :value="old('partner_name') ?? ($model->name ?? null)" required />
                                </div>
                            </div>
                            @if (!isset($model))
                                <div class="row row-cols-1 row-cols-md-2">
                                    <div class="col">
                                        <x-input.text placeholder="ชื่อดีพาร์ทเม้นท์" label="ดีพาร์ทเม้นท์"
                                            name="department_name" :value="old('department_name') ?? ($model->department_name ?? null)" required />
                                    </div>
                                    <div class="col">
                                        <x-input.text placeholder="คีย์เวิร์ดดีพาร์ทเม้นท์" label="คีย์เวิร์ด"
                                            name="department_keyword" :value="old('department_keyword') ??
                                                ($model->department_keyword ?? null)" required />
                                    </div>
                                </div>
                            @endif
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </x-section>
@endsection
