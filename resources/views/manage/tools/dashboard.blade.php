@extends('layouts.master')

@section('content')
    <x-container fluid>
        <x-card>
            <x-card-header class="d-flex align-item-center justify-content-between">
                <div class="fs-5">
                    แดชบอร์ดชุดข้อมูล
                </div>
                <div class="d-flex">
                    <button onclick="exportExcel('{{ $type }}')"
                        class="ms-2 btn btn-success d-flex align-items-center gap-2">
                        <span class="material-icons-round fs-5">launch</span>
                        ส่งออก Excel
                    </button>
                    <a href="{{ route('manage.tools.import', $type) }}"
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
                            <th>Partner / Department</th>
                            <th>ชื่อไฟล์</th>
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
                                <td>{{ $item->owner->name ?? '-' }}</td>
                                <td><a target="_blank" href="{{ $item->full_path }}">{{ $item->unique }}.jpg</a></td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </x-datatable>
                {{ $array_lot }}
            </x-card-body>
        </x-card>
    </x-container>
@endsection
@section('js')
    <script>
        function exportExcel(type) {
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
                    window.open('{{ route('manage.tools.export') }}?lot=' + result.value, '_blank');
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
