@extends('layouts.master')

@section('title')
    <h3>นำเข้าข้อมูล - {{ $campaign->name }} : <b>{{ $campaign->template_type }}</b></h3>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    @switch($campaign->template_type)
                        @case('STD')
                            <h6>ร้านค้าที่ใช้งาน</h6>
                            <ul class="list-group">
                                @foreach ($privileges as $shop_keyword => $privilege)
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">{{ $privilege['title'] }} :
                                                <span class="fw-normal">{{ $shop_keyword }} <span
                                                        class="material-icons-round text-black-50 user-select-none fs-6"
                                                        data-bs-toggle="tooltip" data-bs-title="keyword">error_outline</span></span>
                                            </div>
                                            <ul>
                                                @foreach ($privilege['list'] as $expire => $item)
                                                    <li>{{ $expire }} <span
                                                            class="material-icons-round text-black-50 user-select-none fs-6"
                                                            data-bs-toggle="tooltip" data-bs-title="Expire">error_outline</span>
                                                    </li>
                                                    <ul>
                                                        @foreach ($item as $value)
                                                            <li>{{ $value }} ฿ <span
                                                                    class="material-icons-round text-black-50 user-select-none fs-6"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-title="Value">error_outline</span>&nbsp;<span
                                                                    role="button" class="text-primary material-icons-round fs-6"
                                                                    onclick="copyKeyword('{{ $shop_keyword }}','{{ $value }}','{{ $expire }}')">content_copy</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <p class="text-center mt-3">
                                Mobile | Code | Keyword | Value | Expire
                            </p>
                        @break

                        @case('CTMT')
                            <h6>Template ที่ใช้งาน</h6>
                            <table class="table table-bordered" id="table-template">
                                <thead>
                                    <tr>
                                        <th>Expire</th>
                                        <th>Value</th>
                                        <th>Template</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($templates as $item)
                                        <tr>
                                            <td>{{ $item['expire'] }}</td>
                                            <td>{{ $item['value'] }}</td>
                                            <td>{{ $item['template'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <p class="text-center mt-3">
                                Mobile | Code | Template
                            </p>
                        @break
                    @endswitch
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row" style="max-height: 215px;">
                        <div class="col">
                            <form method="post" action="./upload" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="filepond" id="filepond" class="my-pond" />
                                <hr>
                                <div class="form-group">
                                    <label class="form-label">ประเภทการคั่นข้อมูล : </label>
                                    @php($type_split_data = ['|', '-', ':', ';', ',', '.', '\'', '"'])
                                    @foreach ($type_split_data as $key => $item)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type_split_data"
                                                id="type-{{ $key }}" value="{{ $item }}"
                                                @if ($item == '|') checked @endif>
                                            <label class="form-check-label"
                                                for="type-{{ $key }}">{{ $item }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <div class="col-4">
                                        <x-input label="วันที่เริ่มต้น" name="start_date" :value="date('Y-m-d 00:00:00')" required />
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col">
                            <div class="card bg-light border shadow-none" style="height: 215px">
                                <div class="card-body text-monospace p-2 overflow-auto" id="console_log">
                                    <ul id="result" class="hide-dot"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-info" id="btn-format" onclick="checkFormat()"
                        style="display:none">
                        <i class="material-icons-round">search</i> Check format
                    </button>
                    <button type="button" class="btn btn-primary" id="btn-generate" onclick="generate()"
                        style="display:none">
                        <i class="material-icons-round">terminal</i> Generate
                    </button>
                    <button type="button" class="btn btn-outline-success btn-copy" id="btn-copy-data" onclick="copyData()"
                        style="display:none">
                        <i class="material-icons-round">copy</i> Copy Data
                    </button>
                    <button type="button" class="btn btn-outline-warning text-orange btn-copy" id="btn-copy-sql"
                        onclick="copySql()" style="display:none">
                        <i class="material-icons-round">copy</i> Copy SQL
                    </button>
                    <button type="button" class="btn btn-success btn-export" id="btn-export-data" onclick="exportData()"
                        style="display:none">
                        <i class="material-icons-round">share</i> Export Data
                    </button>
                    <button type="button" class="btn btn-warning btn-export" id="btn-export-sql" onclick="exportSql()"
                        style="display:none">
                        <i class="material-icons-round">share</i> Export SQL
                    </button>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="data-tab" data-bs-toggle="tab"
                                    data-bs-target="#data-tab-pane" type="button" role="tab"
                                    aria-controls="data-tab-pane" aria-selected="true">Data</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="sql-tab" data-bs-toggle="tab"
                                    data-bs-target="#sql-tab-pane" type="button" role="tab"
                                    aria-controls="sql-tab-pane" aria-selected="false">SQL</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="py-3 tab-pane fade show active" id="data-tab-pane" role="tabpanel"
                                aria-labelledby="data-tab" tabindex="0">
                                <table class="table table-bordered" id="table-generate">
                                    <thead>
                                        <tr>
                                            <th>Mobile</th>
                                            <th>Code</th>
                                            <th>Secret code</th>
                                            <th>Unique code</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="sql-tab-pane" role="tabpanel" aria-labelledby="sql-tab"
                                tabindex="0">
                                <pre id="sql-result">

                                </pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#start_date').datetimepicker({
            format: 'Y-m-d H:00:00'
        });
        $('#table-template').dataTable({
            dom: 'ft',
            responsive: true,
            paging: false
        });

        $('#table-generate').dataTable({
            dom: 'ft',
            ordering: false,
            paging: false
        });

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('start_date', $('[name=start_date]').val());
        const pond = FilePond.create(document.getElementById('filepond'), {
            server: {
                url: "{{ route('site.warehouse.upload', $campaign->id) }}",
                process: {
                    method: 'POST',
                    ondata: (formData) => {
                        formData.append('_token', '{{ csrf_token() }}');
                        return formData;
                    },
                },
                revert: null,
            },
            instantUpload: true
        });

        pond.on('addfilestart', (error) => {
            clr('#result');
            showConsole('กำลังอ่านไฟล์...')
            $('#btn-format').hide().attr('disabled', false)
            $('#btn-generate').hide().attr('disabled', false)
            $('.btn-copy').hide()
            $('.btn-export').hide()
            $('#table-generate tbody').empty();
            $('#sql-result').empty();
        });

        pond.on('processfilestart', (error) => {
            showConsole('กำลังอัพโหลดไฟล์...')
        });

        pond.on('processfile', (error) => {
            if (!error) {
                showConsole('อัพโหลดไฟล์เสร็จสิ้น')
                $('#btn-format').show()
            }
        });

        pond.on('removefile', () => {
            clr('#result');
            $('#btn-format').hide().attr('disabled', false)
            $('#btn-generate').hide().attr('disabled', false)
            $('.btn-copy').hide()
            $('.btn-export').hide()
            $('#table-generate tbody').empty();
            $('#sql-result').empty();
        });

        function checkFormat() {
            showConsole('กำลังตรวจสอบไฟล์...')

            formData.append('type_split_data', $('[name=type_split_data]:checked').val());
            $('#btn-format').attr('disabled', true)
            $.ajax({
                url: "{{ route('site.warehouse.check-format', $campaign->id) }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                success: function(res) {
                    clr('#result');
                    if (res.error) {
                        if (typeof res.error === 'object') {
                            $.each(res.error, function(line, data) {
                                showConsole("Line <b>" + line + "</b> : " +
                                    data, 'danger');
                            });
                        } else {
                            showConsole(res.error, 'danger');
                        }
                        $('#btn-format').hide().attr('disabled', false)
                        $('#btn-generate').hide().attr('disabled', false)
                    } else {
                        if (res.status) {
                            showConsole(res.msg, 'success');
                            $('#btn-format').hide().attr('disabled', false)
                            $('#btn-generate').show()
                        }
                    }
                }
            });
        }

        function generate() {
            showConsole('กำลังสร้างข้อมูล...')
            $('#btn-generate').attr('disabled', true)
            $.ajax({
                url: "{{ route('site.warehouse.generate', $campaign->id) }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                success: function(res) {
                    clr('#result');
                    $('#btn-generate').hide().attr('disabled', false)
                    $('.btn-copy').show()
                    $('.btn-export').show()
                    $('#table-generate tbody').empty();
                    $('#sql-result').empty();
                    $.each(res.data, function(indexInArray, data) {
                        let row = '<tr>';
                        row += '<td>' + data.mobile + '</td>';
                        row += '<td>' + data.code + '</td>';
                        row += '<td>' + data.secret_code + '</td>';
                        row += '<td>' + data.unique_code + '</td>';
                        row += '</tr>';
                        $('#table-generate').append(row);
                        $('#sql-result').append(data.sql + '<br>');
                    });
                },
                error: function(res) {
                    showConsole('เกิดข้อผิดพลาด กรุณาตรวจสอบ Log', 'danger');
                    $('#btn-generate').attr('disabled', false)
                }
            });
        }

        function copyKeyword(keyword, value, expire) {
            let type = $('[name=type_split_data]:checked').val()
            let text = keyword + type + value + type + expire
            var $tempInput = $("<input>");
            $("body").append($tempInput);
            $tempInput.val(text).select();
            document.execCommand("copy");
            $tempInput.remove();
        }

        function clr(id) {
            $(id).empty();
        }

        function showConsole(msg, color = "secondary") {
            $('#result').append("<li><span class='text-" + color + "'>" + msg + "</span></li>");
        }
    </script>
@endsection

@section('css')
    <style>
        .hide-dot {
            list-style-type: none;
            padding-left: 0px;
        }
    </style>
@endsection
