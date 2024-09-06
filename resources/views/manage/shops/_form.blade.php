@extends('layouts.master', [
    'prev_route' => url()->previous(),
    'breadcrumb' => [['url' => route('dashboard'), 'label' => 'แดชบอร์ด'], ['url' => route('manage.shops.index'), 'label' => 'ร้านค้า'], empty($model) ? ['label' => 'เพิ่มร้านค้า'] : ['label' => 'แก้ไข้ข้อมูล : ' . $model->name]],
])
