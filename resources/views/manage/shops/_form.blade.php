@extends('layouts.master', [
    'prev_route' => url()->previous(),
    'breadcrumb' => [['url' => route('dashboard'), 'label' => 'แดชบอร์ด'], ['url' => route('manage.shops.index'), 'label' => 'ร้านค้า'], empty($model) ? ['label' => 'เพิ่มร้านค้า'] : ['label' => 'แก้ไข้ข้อมูล : ' . $model->name]],
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
                เพิ่มร้านค้า
            @endif
        </x-slot>
        <div class="container d-flex justify-content-center">
            <div class="col-md-12 col-lg-10 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <x-form :model="$model" route="manage.shops" :params="$model->id ?? null">
                            <div class="row row-cols-1 row-cols-md-2">
                                <div class="col">
                                    <x-input.text placeholder="ร้านค้า" label="ชื่อร้านค้า" name="name" :value="old('name') ?? ($model->name ?? null)"
                                        required />
                                </div>
                                <div class="col">
                                    <x-input.text class="uppercase" placeholder="XXX" label="คีย์เวิร์ด" name="keyword"
                                        :value="old('keyword') ?? ($model->keyword ?? null)" required max="3" min="3" />
                                </div>
                            </div>
                            <div class="row row-cols-1 mb-3">
                                <div class="col">
                                    <label for="tandc" class="form-label">
                                        เงื่อนไขและข้อตกลง
                                    </label>
                                    <textarea name="tandc" id="editor">{{ old('tandc') ?? ($model->tandc ?? null) }}</textarea>
                                </div>
                            </div>
                            <div class="row row-cols-1 row-cols-md-2">
                                <div class="col">
                                    <x-input.file label="Default Template" name="template" accept="image/*"
                                        :path="isset($model) ? $model->getTemplateFilePath() : null" />
                                </div>
                                <div class="col">
                                    <x-input.file label="Default Banner" name="banner" accept="image/*"
                                        :path="isset($model) ? $model->getBannerFilePath() : null" />
                                </div>
                            </div>
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </x-section>
@endsection

@section('script')
    <script>
        $('#editor').trumbowyg({
            lang: 'th',
            resetCss: true
        });
    </script>
    @parent
@endsection
