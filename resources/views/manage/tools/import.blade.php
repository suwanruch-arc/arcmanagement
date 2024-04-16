@extends('layouts.master', ['route' => route('manage.tools.dashboard',$type)])

@section('content')
    <x-container fluid>
        <x-card>
            <x-card-header class="d-flex align-item-center justify-content-between">
                <div class="fs-5">
                    นำเข้าข้อมูล
                </div>
            </x-card-header>
            <x-card-body>
                <div class="row">
                    <div class="col-md-4">
                        <div class="filepond"
                            style="
                            height: 256px;
                            background-color:#f1f0ef;
                            text-align: center;
                            line-height: 256px;
                            border: var(--bs-card-border-width) solid var(--bs-card-border-color);
                            border-radius: var(--bs-card-border-radius);
                            ">
                            กรุณารอสักครู่...
                        </div>
                        <div>

                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body font-logger"
                                style="height: 128px;overflow-y: auto;">
                                <ul class="p-0 m-0" id="logger">
                                    <li>กรุณาเลือกไฟล์...</li>
                                </ul>
                            </div>
                            <div class="card-footer p-2">
                                <div class="row">
                                    <div class="col">
                                        <label for="owner" class="form-label">Partner / Department</label>
                                        <select class="select2 form-select" id="owner">
                                            <option value="0" selected disabled="disabled">กรุณาเลือก</option>
                                            @forelse ($owner_lists as $partner=>$departments)
                                                <optgroup label="{{ $partner }}">
                                                    @forelse ($departments as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @empty
                                                        <option value disabled>ไม่พบข้อมูล</option>
                                                    @endforelse
                                                </optgroup>
                                            @empty
                                                <option value disabled>ไม่พบข้อมูล</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="shop" class="form-label">ร้านค้า <span
                                                class="text-danger">*</span></label>
                                        <select class="select2 form-select" id="shop">
                                            <option value  selected disabled="disabled">กรุณาเลือก</option>
                                            @forelse ($shops as $id => $shop)
                                                <option value="{{ $shop->id }}">[{{ $shop->keyword }}]
                                                    {{ $shop->name }}</option>
                                            @empty
                                                <option value disabled>ไม่พบข้อมูล</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="expire" class="form-label">วันหมดอายุ <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" id="expire" value="{{ date('Y-m-t 23:59:59') }}"
                                            required />
                                    </div>
                                </div>
                                <hr />
                                <button id="btnMakeData" class="btn btn-info"
                                    onclick="checkData('{{ $type }}')">ตรวจสอบข้อมูล</button>
                                <button id="btnMakeData" class="btn btn-primary"
                                    onclick="makeData('{{ $type }}')">สร้างชุดข้อมูล</button>
                                <button id="btnExportExcel" class="btn btn-success">ส่งออกข้อมูล Excel</button>
                                {{-- <button class="btn btn-outline-danger">ลบไฟล์ข้อมูลนำเข้า</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </x-card-body>
        </x-card>
    </x-container>
@endsection

@section('js')
    <script>
        const logger = new Logger('logger');

        const inputFile = document.querySelector('.filepond');

        const pond = FilePond.create(inputFile, {
            labelIdle: "ลากและวางไฟล์ของคุณ หรือ <u><b>เลือกไฟล์</b></u>",
            server: {
                url: "{{ route('manage.tools.load') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                process: {
                    onload: (response) => {
                        return JSON.parse(response);
                    },
                }
            },
        });

        pond.on('addfile', (error, file) => {
            logger.log('เลือกไฟล์เรียบร้อย.');
        });

        pond.on('processfilestart', (progress) => {
            logger.log('กำลังอัพโหลดไฟล์...');
        });

        pond.on('processfile', (error, file, res) => {
            if (error) {
                logger.error('เกิดข้อผิดพลาด กรุณาตรวจสอบอีกครั้ง - ' + error.body);
                return;
            }
            const data = file.serverId.data
            logger.succ('อัพโหลดไฟล์เรียบร้อยแล้ว');
            logger.succ(data)
        });

        pond.on('removefile', (error, file) => {
            logger.error('ลบไฟล์เรียบร้อยแล้ว');
        });

        $('#expire').datetimepicker({
            format: 'Y-m-d 23:59:59',
        });

        function checkData(type) {
            $.ajax({
                type: "GET",
                url: "{{ route('manage.tools.check') }}",
                data: {
                    "type": type
                },
                dataType: "JSON",
                success: function(response) {
                    const res = response
                    if (res.status === 'error') {
                        logger.clear()
                        $.each(res.error, function(i, v) {
                            logger.error(v)
                        });
                    } else {
                        logger.succ('ไฟล์ข้อมูลถูกต้อง สามารถทำการสร้างชุดข้อมูลได้')
                    }
                }
            });
        }

        function makeData(type) {
            const owner = $('#owner').val()
            const shop = $('#shop').val()
            const expire = $('#expire').val()

            if (shop && expire) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('manage.tools.generate') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "type": type,
                        'owner': owner,
                        'shop': shop,
                        'expire': expire
                    },
                    dataType: "JSON",
                    success: function(response) {
                        const res = response
                        if (res.status === 'error') {
                            logger.clear()
                            $.each(res.error, function(i, v) {
                                logger.error(v)
                            });
                        } else {
                            $.each(res.data, function(i, v) {
                                logger.succ(v)
                            });

                        }
                    }
                });
            } else {
                if (!shop) {
                    alert('กรุณาเลือกร้านค้า')
                }
                if (!expire) {
                    alert('กรุณากำหนดวันหมดอายุ')
                }
            }
        }
    </script>
@endsection

@section('css')
    <style>
        ul#logger {
            list-style-type: none;
        }

        ul#logger li:first-child {
            list-style-type: disclosure-closed;
            margin-left: 20px;
        }

        .filepond--root {
            height: 256px;
            margin: 0;

        }

        .filepond--panel-root {
            border: var(--bs-card-border-width) solid var(--bs-card-border-color);
            border-radius: var(--bs-card-border-radius);
        }

        .filepond--drop-label {
            height: 100%;
            line-height: 200px;
        }
    </style>
@endsection
