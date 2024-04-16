@extends('layouts.master')

@section('content')
    <x-container fluid>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8 col-xxl-6">
                <x-card>
                    <x-card-header class="d-flex align-items-center gap-2 fs-5">
                        <span class="material-icons-round ">
                            handyman
                        </span>
                        เครื่องมือสร้างข้อมูล
                    </x-card-header>
                    <x-card-body>
                        <div class="row row-cols-1 row-cols-sm-2 text-center">
                            <div class="col">
                                <div class="card mb-4 rounded-3">
                                    <div class="card-header py-3 d-flex align-items-center gap-2 fs-5">
                                        <span class="material-icons-round">
                                            qr_code_2
                                        </span>
                                        ชุดข้อมูล QRCode
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ route('manage.tools.dashboard', 'qrcode') }}" type="button"
                                            class="w-100 btn btn-lg btn-outline-primary d-flex align-items-center gap-2">
                                            <span class="material-icons-round fs-6">
                                                launch
                                            </span>
                                            เข้าใช้งาน
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card mb-4 rounded-3">
                                    <div class="card-header py-3 d-flex align-items-center gap-2 fs-5">
                                        <span class="material-icons-round">
                                            document_scanner
                                        </span>
                                        ชุดข้อมูล Barcode
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ route('manage.tools.dashboard', 'barcode') }}" type="button"
                                            class="w-100 btn btn-lg btn-outline-primary  d-flex align-items-center gap-2">
                                            <span class="material-icons-round fs-6">
                                                launch
                                            </span>
                                            เข้าใช้งาน
                                        </a>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col">
                                <div class="card mb-4 rounded-3">
                                    <div class="card-header py-3 d-flex align-items-center gap-2 fs-5">
                                        <span class="material-icons-round">
                                            source
                                        </span>
                                        ชุดข้อมูล Map Link
                                    </div>
                                    <div class="card-body">
                                        <a href="{{ route('manage.tools.dashboard', 'maplink') }}" type="button"
                                            class="w-100 btn btn-lg btn-outline-primary  d-flex align-items-center gap-2">
                                            <span class="material-icons-round fs-6">
                                                launch
                                            </span>
                                            เข้าใช้งาน
                                        </a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </x-card-body>
                </x-card>
            </div>
        </div>
    </x-container>
@endsection
