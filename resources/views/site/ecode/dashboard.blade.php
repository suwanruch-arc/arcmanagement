@extends('layouts.master', ['route' => route('site.ecode.index')])

@section('content')
    <x-container fluid>
        <x-card>
            <x-card-header class="d-flex align-item-center justify-content-between">
                <div class="fs-5">
                    แดชบอร์ดชุดข้อมูล : {{ $campaign->name }}
                </div>
                <div class="d-flex">
                    <button onclick="exportExcel()" class="ms-2 btn btn-success d-flex align-items-center gap-2">
                        <span class="material-icons-round fs-5">launch</span>
                        ส่งออก Excel
                    </button>
                    <a href="{{ route('site.ecode.import', $campaign->id) }}"
                        class="ms-2 btn btn-primary d-flex align-items-center gap-2">
                        <span class="material-icons-round fs-5">input</span>
                        นำเข้าข้อมุล
                    </a>
                </div>
            </x-card-header>
            <x-card-body>
                <x-datatable>
                    <thead>
                        <tr>
                            <th>ประเภท</th>
                            <th>Lot</th>
                            <th>Code</th>
                            <th>ราคา</th>
                            <th>วันหมดอายุ</th>
                            <th>ร้านค้า</th>
                            <th>ชื่อไฟล์</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->date_lot }}-{{ str_pad($item->number_lot, 3, 0, STR_PAD_LEFT) }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->value }}</td>
                                <td>{{ $item->expire_date }}</td>
                                <td>[{{ $item->shop->keyword }}] {{ $item->shop->name }}</td>
                                <td><a target="_blank" href="{{ $item->path }}">{{ $item->file_name }}</a></td>
                                <td>
                                    <form data-bs-toggle="tooltip" data-bs-placement="top" class="d-inline" method="post"
                                        action="{{ route('site.ecode.remove') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item->id }}" />
                                        <button class="btn btn-sm btn-danger m-1" type="submit" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="ลบแคมเปญ">
                                            <i class="material-icons-round fs-6">delete</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </x-datatable>
            </x-card-body>
            {{ $array_lot }}
        </x-card>
    </x-container>
@endsection
@section('js')
    <script>
        $('form').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'คุณแน่ใจใช่ไหม?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ลบ',
                cancelButtonText: 'ย้อนกลับ',
                focusConfirm: false,
                focusCancel: true,
                showClass: {
                    popup: "animate__animated animate__headShake animate__faster"
                },
            }).then((action) => {
                if (action.isConfirmed) {
                    e.currentTarget.submit();
                }
            })
        });

        function exportExcel() {
            Swal.fire({
                imageHeight: 100,
                imageUrl: 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/34/Microsoft_Office_Excel_%282019%E2%80%93present%29.svg/1101px-Microsoft_Office_Excel_%282019%E2%80%93present%29.svg.png',
                title: "ส่งออก Excel",
                input: "select",
                inputOptions: {!! $array_lot !!},
                inputPlaceholder: "กรุณาเลือก Lot",
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    if (result.value) {
                        window.open('{{ route('site.ecode.export') }}?campaign_id={{$campaign->id}}&lot=' + result.value, '_blank');
                    } else {
                        exportExcel()
                    }
                }
            });;
        }

        function copyToClip(id) {
            var copyText = document.getElementById(id);
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);
            alert("Copied the text: " + copyText.value);
        }
    </script>
@endsection
