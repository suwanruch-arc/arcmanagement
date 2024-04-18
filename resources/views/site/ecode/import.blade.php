@extends('layouts.master', ['route' => route('site.ecode.dashboard', $campaign->id)])

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
                            <div class="card-body font-logger" style="height: 128px;overflow-y: auto;">
                                <ul class="p-0 m-0" id="logger">
                                    <li>กรุณาเลือกไฟล์...</li>
                                </ul>
                            </div>
                            <div class="card-footer p-3">
                                <div class="row">
                                    <div class="col">
                                        <label for="type" class="form-label">
                                            ประเภท Code <span class="text-danger">*</span>
                                            <small class="font-monospace text-black-50"><i>[Default : QRCode]</i></small>
                                        </label>
                                        <select class="select2 form-select" id="type">
                                            <option value="qrcode" selected>QRCode</option>
                                            <option value="barcode">Barcode</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="shop" class="form-label">ร้านค้า <span
                                                class="text-danger">*</span></label>
                                        <select class="select2 form-select" id="shop_id" autofocus>
                                            <option value selected disabled="disabled">กรุณาเลือก</option>
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
                                <div class="d-flex gap-2">
                                    <button id="btnMakeData" class="btn btn-info" onclick="checkData()">
                                        1. ตรวจสอบข้อมูล
                                    </button>
                                    <button id="btnMakeData" class="btn btn-primary" onclick="makeData()">
                                        2. สร้างชุดข้อมูล
                                    </button>
                                    <button id="btnExportExcel" class="btn btn-success" onclick="exportData()">
                                        3. ส่งออกข้อมูล Excel <small>(<i>เฉพาะ Lot</i>)</small>
                                    </button>
                                    <input type="text" class="form-control" id="lot_syntax" readonly
                                        style="width: 150px">
                                </div>
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
            labelIdle: "ลากและวางไฟล์ของคุณ หรือ <u><b>เลือกไฟล์</b></u><br><br><small class='font-monospace'>Format file : [code|value</small>]",
            server: {
                url: "{{ route('site.ecode.load') }}",
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


        function checkData() {
            const type = $('#type').val()
            const shop = $('#shop_id').val()
            const expire = $('#expire').val()

            if (shop && expire) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('site.ecode.check') }}",
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
            } else {
                if (!shop) {
                    alert('กรุณาเลือกร้านค้า')
                }
                if (!expire) {
                    alert('กรุณากำหนดวันหมดอายุ')
                }
            }
        }

        function makeData() {
            const type = $('#type').val()
            const shop = $('#shop_id').val()
            const expire = $('#expire').val()

            if (shop && expire) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('site.ecode.generate') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "type": type,
                        'shop': shop,
                        'expire': expire,
                        'campaign_id': '{{ $campaign->id }}'
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
                            $('#lot_syntax').val(res.lot);
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

        function exportData() {
            const lot = $('#lot_syntax').val();
            window.open('{{ route('site.ecode.export') }}?campaign_id={{ $campaign->id }}&lot=' + lot, '_blank');
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
