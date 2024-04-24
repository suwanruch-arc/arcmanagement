@extends('layouts.master', ['route' => route('manage.tools.dashboard')])

@section('content')
    <x-container fluid>
        <x-card>
            <x-card.header class="fs-5 justify-content-between pe-2">
                <div class="">
                    <span class="material-icons-round ">
                        upload
                    </span>
                    อัปโหลดไฟล์
                </div>
            </x-card.header>
            <x-card.body>
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
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body font-logger" style="height: 128px;overflow-y: auto;">
                                <ul class="p-0 m-0" id="logger">
                                    <li>กรุณาเลือกไฟล์...</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card.body>
        </x-card>
    </x-container>
@endsection

@section('js')
    @parent
    <script>
        const logger = new Logger('logger');

        const inputFile = document.querySelector('.filepond');

        const pond = FilePond.create(inputFile, {
            labelIdle: "ลากและวางไฟล์ของคุณ หรือ <u><b>เลือกไฟล์</b></u><br><br><small class='font-monospace'>Format file : [<span id='formatLabel'></span>]</small>",
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
