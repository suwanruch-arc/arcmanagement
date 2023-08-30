@extends('layouts.master')

@section('title')
    <h3>นำเข้าข้อมูล - {{ $campaign->name }} : <b>{{ $campaign->template_type }}</b></h3>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    ชื่อร้านค้า
                                </th>
                                <th>
                                    คีย์เวิร์ด
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($shop_lists as $shop)
                                <tr>
                                    <td>
                                        {{ $shop->name }}
                                    </td>
                                    <td>
                                        {{ $shop->keyword }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">ไม่พบร้านค้า Privilege ที่ตั้งค่าไว้</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
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
                                <input type="file" name="filepond" id="filepond" class="my-pond" />
                                <p class="text-center">
                                    Mobile | Code | Shop | Value | Expire
                                </p>
                            </form>
                        </div>
                        <div class="col">
                            <div class="card bg-light border shadow-none" style="height: 215px">
                                <div class="card-body text-monospace p-2 overflow-auto" id="console_log">
                                    <ul id="result"></ul>
                                </div>
                                <div id="card_footer" class="card-footer">
                                    Choose file...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-info wave" id="btn-format" style="display: none;">
                        <span data-feather="search"></span> Check format</button>
                    <button type="button" class="btn btn-primary wave" id="btn-upload" style="display: none;">
                        <span data-feather="upload"></span> Upload
                    </button>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const inputElement = document.getElementById('filepond');
        const pond = FilePond.create(inputElement, {
            instantUpload: false
        });

        pond.on('addfile', (e) => {
            $('#btn-format').show();
            $('#btn-upload').hide();
        });

        pond.on('removefile', (e) => {
            $('#btn-format').hide();
            $('#btn-upload').hide();
        });

        $('#btn-format').on('click', function() {
            const files = pond.getFiles();
            if (files.length > 0) {
                const file = files[0]; // Assuming you only want to upload the first file

                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('file', file.file);
                formData.append('type_split_data', $('[name=type_split_data]:checked').val());

                $.ajax({
                    url: "{{ route('site.warehouse.check-format', $campaign->id) }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function(res) {
                        console.log(JSON.parse(res));
                        if (Array.isArray(res.error)) {
                            $.each(res.error, function(line, data) {
                                $('#result').append("<li>Line <b>" + line + "</b> : " + data +
                                    "</li>");
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Upload failed:', error);
                    }
                });
            }
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
