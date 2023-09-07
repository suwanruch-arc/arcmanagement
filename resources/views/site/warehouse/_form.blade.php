@extends('layouts.master')

@section('title')
    <h3>นำเข้าข้อมูล - {{ $campaign->name }} : <b>{{ $campaign->template_type }}</b></h3>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6>ร้านค้าที่ใช้งาน</h6>
                    <ul class="list-group">
                        @foreach ($privileges as $shop_keyword => $privilege)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">{{ $privilege['title'] }} :
                                        <span class="fw-normal">{{ $shop_keyword }}</span>
                                    </div>
                                    <ul>
                                        @foreach ($privilege['list'] as $expire => $item)
                                            <li>{{ $expire }}</li>
                                            <ul>
                                                @foreach ($item as $value)
                                                    <li>{{ $value }} ฿</li>
                                                @endforeach
                                            </ul>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @endforeach
                    </ul>
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
                                <hr>
                                <input type="file" name="filepond" id="filepond" class="my-pond" />
                                <hr>
                                <p class="text-center">
                                    Mobile | Code | Keyword | Value | Expire
                                </p>
                            </form>
                        </div>
                        <div class="col">
                            <div class="card bg-light border shadow-none" style="height: 215px">
                                <div class="card-body text-monospace p-2 overflow-auto" id="console_log">
                                    <ul id="result"></ul>
                                </div>
                                <div id="card_footer" class="card-footer">
                                    <small>Status : <span id="status">Choose file</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-info wave" id="btn-format" style="display: none;">
                        Check format
                    </button>
                    <button type="button" class="btn btn-primary wave" id="btn-generate" style="display: none;">
                        Generate
                    </button>
                    <button type="button" class="btn btn-warning wave" id="btn-insert" style="display: none;">
                        Insert Data
                    </button>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row">
                        <table class="table ">
                            <tbody id="table-generate">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('type_split_data', $('[name=type_split_data]:checked').val());
        const inputElement = document.getElementById('filepond');
        const pond = FilePond.create(inputElement, {
            server: {
                url: "{{ route('site.warehouse.upload', $campaign->id) }}",
                process: {
                    method: 'POST',
                    ondata: (formData) => {
                        formData.append('_token', '{{ csrf_token() }}');
                        return formData;
                    },
                },
            },
            instantUpload: true
        });

        var pond_ids = [];

        if (pond.getFiles().length != 0) { // "pond" is an object, created by FilePond.create
            pond.getFiles().forEach(function(file) {
                pond_ids.push(file.id);
            });
        }

        pond.on('processfile', (error) => {
            if (!error) {
                $('#btn-format').show().prop('disabled', false);
                $('#btn-generate').hide().prop('disabled', false);
            }
        });

        pond.on('updatefiles', (e) => {
            $('#btn-format').hide().prop('disabled', false);
            $('#btn-generate').hide().prop('disabled', false);
        });

        $('#btn-format').on('click', function() {
            $('#btn-format').removeClass('wave').html('Checking...').prop('disabled', true);
            $('#status').html('File loaded');

            $.ajax({
                url: "{{ route('site.warehouse.check-format', $campaign->id) }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'JSON',
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
                        $('#btn-format').hide().prop('disabled', false);
                        pond.removeFiles(pond_ids);
                    } else {
                        if (res.status === 'ok') {
                            showConsole(res.msg, 'success');
                            $('#status').html('Ok');
                            $('#btn-format').hide().addClass('wave').prop('disabled', false);
                            $('#btn-generate').show();
                        }
                    }

                },
                error: function(xhr, status, error) {
                    $('#btn-format').addClass('wave').prop('disabled', false);
                },
                complete: function() {
                    $('#btn-format').html('Check format')
                }
            });
        });

        $('#btn-generate').on('click', function() {
            $(this).html('Generating...')
                .removeClass('wave').prop('disabled', true);

            $.ajax({
                url: "{{ route('site.warehouse.generate', $campaign->id) }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(res) {
                    clr('#result');
                    $('#table-generate').empty();
                    $.each(res, function(indexInArray, data) {
                        let row = '<tr>';
                        row += '<td>' + data.mobile + '</td>';
                        row += '<td>' + data.code + '</td>';
                        row += '<td>' + data.unique + '</td>';
                        row += '<td>' + data.secret_code + '</td>';
                        row += '</tr>';
                        $('#table-generate').append(row);

                    });
                },
                error: function(xhr, status, error) {
                    $('#btn-generate').addClass('wave').prop('disabled', false);
                },
                complete: function() {
                    $('#btn-generate').html('Generate')
                }
            });
        });

        function clr(id) {
            $(id).empty();
        }

        function showConsole(msg, color) {
            $('#result').append("<li><span class='text-" + color + "'>" + msg + "</span></li>");
        }

        $(document).ajaxStart(function() {
            $("#status").html('Loading...');
        });
    </script>
@endsection

@section('css')
    <style>
        .wave {
            position: relative;
            overflow: hidden;
        }

        .wave::before {
            content: '';
            position: absolute;
            top: -1px;
            left: -3px;
            right: -3px;
            bottom: -1px;
            border: 3px solid #ffffff;
            border-radius: 10px;
            opacity: 0;
            transform-origin: center;
            animation: wave-animation 1s linear infinite;
        }

        @keyframes wave-animation {
            0% {
                transform: scale(0.9);
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 0;
            }
        }
    </style>
@endsection
