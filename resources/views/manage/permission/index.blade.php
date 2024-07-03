@extends('layouts.master', ['breadcrumb' => [['url' => route('dashboard'), 'label' => 'แดชบอร์ด'], ['label' => 'จัดการสิทธิ์']]])

@section('content')
    <x-section>
        <x-slot name="title">
            <span class="material-symbols-rounded">
                format_list_bulleted
            </span>
            จัดการสิทธิ์
        </x-slot>
        <x-slot name="toolbar">
            <div class="d-flex gap-2">
                <x-button color="warning" icon="bolt" data-bs-toggle="modal" data-bs-target="#exampleModal" />
                <x-button label="บันทึก" color="success" />
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static">
                <div class="modal-dialog  modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Quick action</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="50%" class="text-center align-middle" rowspan="2">
                                            รายชื่อ
                                        </th>
                                        <th width="50%" class="text-center align-middle" colspan="5">
                                            สิทธิ์
                                        </th>
                                    </tr>
                                    <tr>
                                        <th width="10%" class="text-center align-middle">สร้าง</th>
                                        <th width="10%" class="text-center align-middle">แก้ไข</th>
                                        <th width="10%" class="text-center align-middle">ดู</th>
                                        <th width="10%" class="text-center align-middle">ลบ</th>
                                        <th width="10%" class="text-center align-middle">คืนค่า</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($partners as $partner)
                                        <tr>
                                            <td class="align-middle fw-bold">
                                                {{ $partner->name }}
                                            </td>
                                            <td class="td-center">
                                                <input class="form-check-input" type="checkbox" name="create">
                                            </td>
                                            <td class="td-center">
                                                <input class="form-check-input" type="checkbox" name="update">
                                            </td>
                                            <td class="td-center">
                                                <input class="form-check-input" type="checkbox" name="read">
                                            </td>
                                            <td class="td-center">
                                                <input class="form-check-input" type="checkbox" name="delete">
                                            </td>
                                            <td class="td-center">
                                                <input class="form-check-input" type="checkbox" name="restore">
                                            </td>
                                        </tr>
                                        @foreach ($partner->departments as $department)
                                            <tr>
                                                <td class="ps-4">
                                                    {{ $department->name }}
                                                </td>
                                                <td class="td-center">
                                                    <input class="form-check-input" type="checkbox" name="create">
                                                </td>
                                                <td class="td-center">
                                                    <input class="form-check-input" type="checkbox" name="update">
                                                </td>
                                                <td class="td-center">
                                                    <input class="form-check-input" type="checkbox" name="read">
                                                </td>
                                                <td class="td-center">
                                                    <input class="form-check-input" type="checkbox" name="delete">
                                                </td>
                                                <td class="td-center">
                                                    <input class="form-check-input" type="checkbox" name="restore">
                                                </td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td class="td-center" colspan="6">ไม่มีข้อมูล</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            <button type="button" class="btn btn-success">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <x-button color="primary" label="โหลดข้อมูล" size="sm" class="disabled" id="load-data" />
                            <hr />
                            <div id="jstree">
                                @foreach (config('menu') as $menu)
                                    <ul>
                                        @if (isset($menu['id']))
                                            <li data-jstree='{"disabled":true}' class="jstree-open"
                                                id="{{ $menu['id'] ?? null }}">{{ $menu['label'] }}
                                                @if (isset($menu['children']) && !empty($menu['children']) && isset($menu['id']))
                                                    <ul>
                                                        @foreach ($menu['children'] as $children)
                                                            <li id="{{ $children['id'] ?? null }}">
                                                                {{ $children['label'] }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <x-button class="mb-2" label="เพิ่มผู้ใช้งาน" color="primary" size="sm"
                                        data-bs-toggle="modal" data-bs-target="#selectUserModal" />
                                    <div class="modal fade" id="selectUserModal" data-bs-backdrop="static"
                                        tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5">
                                                        เพิ่มผู้ใช้งาน
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" placeholder="ค้นหา"
                                                            id="search_user">
                                                        <button class="btn btn-primary btn-sm" type="button"
                                                            onclick="searchUser()">
                                                            ค้นหา
                                                        </button>
                                                    </div>
                                                    <hr />
                                                    <div id="result-user-list"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-success btn-sm">เพิ่ม</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card overflow-auto" style="max-height: 25em;">
                                        <div class="card-body">
                                            <ul class="list">
                                                <li>
                                                    test 1
                                                </li>
                                                <ul class="list">
                                                    <li>

                                                        test 1
                                                    </li>
                                                    <ul class="list">
                                                        <li>
                                                            <input class="form-check-input" type="checkbox" />
                                                            test 1
                                                        </li>
                                                        <li>
                                                            <input class="form-check-input" type="checkbox" />
                                                            test 1
                                                        </li>
                                                    </ul>
                                                </ul>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <table>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-section>
@endsection

@section('script')
    @parent
    <script>
        function searchUser() {
            var query = $('#search_user').val();
            $.ajax({
                url: "{{ route('api.search.get-user') }}",
                type: 'GET',
                dataType: "HTML",
                data: {
                    search: query
                },
                success: function(data) {
                    $('#result-user-list').html(data);
                    $('#selectUserModal').modal('show');
                }
            })
        }

        $('.page-link').on('click', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.post(url, $('#search_user').serialize(), function(data) {
                console.log(data);
                $('#posts').html(data);
            });
        });

        $('#jstree').on("changed.jstree", function(e, data) {
            const selected = data.selected
            if (selected.length) {
                $('#load-data').removeClass('disabled')
            } else {
                $('#load-data').addClass('disabled')
            }

        }).jstree({
            "core": {
                "multiple": false,
                "themes": {
                    "variant": "large",
                    "icons": false
                },
            },
            "plugins": ["changed"]
        });
    </script>
@endsection

@section('style')
    @parent
    <style>
        ul.list {
            list-style-type: none;
            padding-left: 10px;
        }
    </style>
@endsection
