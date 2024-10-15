@extends('layouts.master', [
    'prev_route' => url()->previous(),
    'breadcrumb' => [['url' => route('dashboard'), 'label' => 'แดชบอร์ด'], ['url' => route('site.campaigns.index'), 'label' => 'แคมเปญ'], ['url' => route('site.campaigns.pre-create', ['template_type' => request('template_type') ?? null, 'owner_id' => request('owner_id') ?? null]), 'label' => 'เลือกประเภท'], empty($model) ? ['label' => 'เพิ่มแคมเปญ'] : ['label' => 'แก้ไข้ข้อมูล : ' . $model->name]],
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
                เพิ่มแคมเปญ
            @endif
        </x-slot>
        <div class="container d-flex justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <x-form :model="$model" route="site.campaigns" :params="$model->id ?? null">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="row row-cols-1 row-cols-md-2">
                                        <div class="col">
                                            <x-input.text placeholder="ชื่อแคมเปญ" label="แคมเปญ" name="name"
                                                :value="old('name') ?? ($model->name ?? null)" required />
                                        </div>
                                        <div class="col">
                                            <x-input.text placeholder="ABCxxx" label="คีย์เวิร์ด" name="keyword"
                                                :value="old('keyword') ?? ($model->keyword ?? null)" required />
                                        </div>
                                    </div>
                                    <div class="row row-cols-1 row-cols-md-2">
                                        <div class="col">
                                            <x-input.date format="Y-m-d H:00:00" label="วันที่เริ่มต้น" name="start_date"
                                                :value="old('start_date') ??
                                                    ($model->start_date ?? now()->format('Y-m-01 00:00:00'))" required />
                                        </div>
                                        <div class="col">
                                            <x-input.date format="Y-m-d H:59:59" label="วันที่สิ้นสุด" name="end_date"
                                                :value="old('end_date') ??
                                                    ($model->end_date ?? now()->format('Y-m-t 23:59:59'))" required />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <x-input.text label="รายละเอียด" rows="5" type="area"
                                                name="description" :value="old('description') ?? ($model->description ?? null)" />
                                        </div>
                                        <div class="col-12">
                                            <x-assign-lists :selected="old('description') ?? ($model->description ?? null)" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <label class="form-label">
                                                ข้อความแจ้งเตือนยืนยันรับสิทธิ์
                                            </label>
                                            <div class="card mx-auto text-center" style="width: 32em;">
                                                <div class="swal2-icon swal2-warning my-3" style="display: flex;">
                                                    <div class="swal2-icon-content">!</div>
                                                </div>
                                                <div class="mx-auto w-50">
                                                    <x-input.text name="settings[alert][title]" id="setting-alert-title"
                                                        :value="old('settings.alert.title') ??
                                                            ($model->settings->alert->title ?? 'ยืนยันรับสิทธิ์')" />
                                                </div>
                                                <div class="mx-auto w-75">
                                                    <x-input.text type="area" name="settings[alert][description]"
                                                        id="setting-alert-description" :value="old('settings.alert.description') ??
                                                            ($model->settings->alert->description ??
                                                                '*ถ้ากดรับสิทธิแล้ว ไม่สามารถแก้ไขหรือยกเลิกได้')" />
                                                </div>
                                                <div class="mx-auto w-75 row">
                                                    <div class="col">
                                                        <x-input.text name="settings[alert][confirm]"
                                                            id="setting-alert-confirm" :value="old('settings.alert.confirm') ??
                                                                ($model->settings->alert->confirm ?? 'รับสิทธิ์')">
                                                            <x-slot name="prepend">
                                                                <input class="form-control form-control-color"
                                                                    type="color" name="settings[alert][color][confirm]"
                                                                    id="setting-alert-color-confirm"
                                                                    value="{{ old('settings.alert.color.confirm') ?? ($model->settings->alert->confirm ?? '#02B875') }}" />
                                                            </x-slot>
                                                        </x-input.text>
                                                    </div>
                                                    <div class="col">
                                                        <x-input.text name="settings[alert][cancel]"
                                                            id="setting-alert-cancel" :value="old('settings.alert.cancel') ??
                                                                ($model->settings->alert->cancel ?? 'ยกเลิก')">
                                                            <x-slot name="prepend">
                                                                <input class="form-control form-control-color"
                                                                    type="color" name="settings[alert][color][cancel]"
                                                                    id="setting-alert-color-cancel"
                                                                    value="{{ old('settings.alert.color.cancel') ?? ($model->settings->alert->cancel ?? '#D9534F') }}" />
                                                            </x-slot>
                                                        </x-input.text>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <div class="row row-cols-1 row-cols-md-2">
                                                <div class="col">
                                                    <x-input.text type="color" label="สีหลัก" name="settings[color][main]" id="setting-color-main"
                                                        :value="old('settings.color.main') ??
                                                            ($model->settings->color->main ?? '#FFFFFF')"/>
                                                </div>
                                                <div class="col">
                                                    <x-input.text type="color" label="สีรอง" name="settings[color][secondary]" id="setting-color-secondary"
                                                        :value="old('settings.color.secondary') ??
                                                            ($model->settings->color->secondary ?? '#2196F3')" />
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">
                                                        ปุ่มรับสิทธิ์
                                                    </label>
                                                    <x-input.text name="settings[button][redeem]" id="setting-button-redeem"
                                                        :value="old('settings.button.redeem') ??
                                                            ($model->settings->button->redeem ?? 'กดรับสิทธิ์')">
                                                        <x-slot name="prepend">
                                                            <input class="form-control form-control-color" type="color"
                                                                name="settings[button][color][redeem]"
                                                                id="setting-button-color-redeem"
                                                                value="{{ old('settings.button.color.redeem') ?? ($model->settings->button->color->redeem ?? '#02B875') }}" />
                                                        </x-slot>
                                                    </x-input.text>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">
                                                        ปุ่มดู
                                                    </label>
                                                    <x-input.text name="settings[button][view]" id="setting-button-view"
                                                        :value="old('settings.button.view') ??
                                                            ($model->settings->button->view ?? 'ดูโค้ด')">
                                                        <x-slot name="prepend">
                                                            <input class="form-control form-control-color" type="color"
                                                                name="settings[button][color][view]"
                                                                id="setting-button-color-view"
                                                                value="{{ old('settings.button.color.view') ?? ($model->settings->button->color->view ?? '#F0AD4E') }}" />
                                                        </x-slot>
                                                    </x-input.text>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">
                                                        ปุ่มรับสิทธิ์แล้ว
                                                    </label>
                                                    <x-input.text name="settings[button][already]"
                                                        id="setting-button-already" :value="old('settings.button.already') ??
                                                            ($model->settings->button->already ??
                                                                'คุณได้รับสิทธิ์แล้ว')">
                                                        <x-slot name="prepend">
                                                            <input class="form-control form-control-color" type="color"
                                                                name="settings[button][color][already]"
                                                                id="setting-button-color-already"
                                                                value="{{ old('settings.button.color.already') ?? ($model->settings->button->color->already ?? '#ADB5BD') }}" />
                                                        </x-slot>
                                                    </x-input.text>
                                                </div>
                                                <div class="col">
                                                    <label class="form-label">
                                                        ปุ่มหมดอายุ
                                                    </label>
                                                    <x-input.text name="settings[button][expired]"
                                                        id="setting-button-expired" :value="old('settings.button.expired') ??
                                                            ($model->settings->button->expired ?? 'หมดอายุ')">
                                                        <x-slot name="prepend">
                                                            <input class="form-control form-control-color" type="color"
                                                                name="settings[button][color][expired]"
                                                                id="setting-button-color-expired"
                                                                value="{{ old('settings.button.color.expired') ?? ($model->settings->button->color->expired ?? '#D9534F') }}" />
                                                        </x-slot>
                                                    </x-input.text>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </x-section>
@endsection

@section('script')
    <script>
        // swal.fire({
        //     icon: 'warning',
        //     title: 'ยืนยันรับสิทธิ์',
        //     html: '*ถ้ากดรับสิทธิแล้ว ไม่สามารถแก้ไขหรือยกเลิกได้',
        //     showCancelButton: true,
        //     cancelButtonColor: "#F44336",
        //     cancelButtonText: 'cancel',
        //     confirmButtonText: 'confirm',
        //     confirmButtonColor: "#4CAF50",
        // });
        $('#start_date').datetimepicker({
            onShow: function(ct) {
                this.setOptions({
                    maxDate: $('#end_date').val() ? $('#end_date').val() : false
                })
            },
        });
        $('#end_date').datetimepicker({
            onShow: function(ct) {
                this.setOptions({
                    minDate: $('#start_date').val() ? $('#start_date').val() : false
                })
            },
        });
    </script>
    @parent
@endsection
