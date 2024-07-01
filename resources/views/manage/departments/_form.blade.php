@extends('layouts.master', [
    'prev_route' => url()->previous(),
    'breadcrumb' => [['url' => route('dashboard'), 'label' => 'แดชบอร์ด'], ['url' => route('manage.partners.index'), 'label' => 'พาร์ทเนอร์'], ['url' => route('manage.partners.show', $partner->id), 'label' => $partner->name], empty($model) ? ['label' => 'เพิ่มดีพาร์ทเม้นท์'] : ['label' => 'แก้ไข้ข้อมูล : ' . $model->name]],
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
                เพิ่มดีพาร์ทเม้นท์ : {{ $partner->name }}
            @endif
        </x-slot>
        <div class="container d-flex justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <x-form :model="$model" route="manage.partners.departments" :params="['partner' => $partner->id, 'department' => $model->id ?? null]">
                            <div class="row row-cols-1 row-cols-md-2">
                                <div class="col">
                                    <x-input.text placeholder="ชื่อดีพาร์ทเม้นท์" label="ดีพาร์ทเม้นท์" name="name"
                                        :value="old('name') ?? ($model->name ?? null)" required />
                                </div>
                                <div class="col">
                                    <x-input.text placeholder="คีย์เวิร์ดดีพาร์ทเม้นท์" label="คีย์เวิร์ด" name="keyword"
                                        :value="old('keyword') ?? ($model->keyword ?? null)" required />
                                </div>
                                <div class="col">
                                    <x-input.file label="โลโก้" name="logo_file" accept="image/*" :path="isset($model) ? $model->getFilePath() : null" />
                                </div>
                                <div class="col">
                                    <x-input.text placeholder="--" label="ขนาด" name="logo_width" :value="old('logo_width') ?? ($model->logo_width ?? 30)"
                                        append="px" />
                                </div>
                            </div>
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </x-section>
@endsection
