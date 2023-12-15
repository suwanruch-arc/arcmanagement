@extends('layouts.master', ['route' => url()->previous()])

@section('title')
    <h3>Warehouse - {{ $campaign->name }}</h3>
@endsection

@section('content')
    <x-container fluid>
        <div class="d-flex justify-content-between">
            <a href="#" id="change-privilege"
                class="text-bg-secondary text-decoration-none rounded-top mx-2 px-3 py-1 fs-6 border-none">
                เปลี่ยน Privilege
            </a>
            <a href="{{ route('site.warehouse.import', $campaign->id) }}"
                class="text-bg-primary text-decoration-none rounded-top mx-2 px-3 py-1 fs-6">
                <span data-feather="upload"></span>&nbsp;นำเข้าข้อมูล
            </a>
        </div>
        <x-card>
            <table class="table table-bordered" id="table-code">
                <thead>
                    <tr>
                        <th></th>
                        <th>Import</th>
                        <th>Expire</th>
                        <th>Value</th>
                        <th>Code</th>
                        <th>Msisdn</th>
                        <th>Secret Code</th>
                        <th>Unique Code</th>
                        <th>Link</th>
                        <th>Banner/Template</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($uniques as $unique)
                        @php
                            switch ($campaign->template_type) {
                                case 'STD':
                                    $field = 'banner';
                                    break;
                                case 'CTMT':
                                    $field = 'template';
                                    break;
                            }
                            $privilege_id = $campaign
                                ->privileges()
                                ->where('keyword', $unique->privilege_keyword)
                                ->value('id');
                            $link = env('APP_URL_REDEEM') . Str::lower("{$unique->partner_keyword}/{$campaign->keyword}/") . $unique->unique_code;
                        @endphp
                        <tr data-id="{{ $unique->id }}">
                            <td class="text-center align-middle">
                                <input class="form-check-input" type="checkbox" value="{{ $unique->id }}"
                                    id="select-{{ $unique->id }}" />
                            </td>
                            <td>{{ $unique->import_date }}</td>
                            <td>{{ $unique->expire_date }}</td>
                            <td>{{ $unique->value }}</td>
                            <td>{{ $unique->code }}</td>
                            <td>{{ $unique->msisdn }}</td>
                            <td>{{ $unique->secret_code }}</td>
                            <td>{{ $unique->unique_code }}</td>
                            <td>
                                <a href="{{ $link }}" target="_blank">{{ $link }}</a>
                            </td>
                            <td>
                                <img class="img-thumbnail"
                                    width='128px'src='{{ Image::get($privilege_id, 'privileges', $field) }}' />
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </x-card>
    </x-container>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#table-code').dataTable({
                columnDefs: [{
                    orderable: false,
                    targets: 0
                }],
                order: [
                    [1, 'asc']
                ]
            })

            $('#change-privilege').click(function(e) {
                e.preventDefault()
                let id = [];
                $.each($("[id^='select-']:checked"), function(indexInArray, data) {
                    id.push(parseInt(data.value))
                });

                if (id.length > 0) {
                    openCenteredPopup("{{ route('site.warehouse.change-privilege', $campaign->id) }}", id)
                }else{
                    swal.fire('กรุณาเลือกข้อมูลก่อน')
                }
            });

            $("tr").on('click', function(e) {
                const r_id = $(this).attr("data-id");
                var chk = $(this).closest("tr").find("input:checkbox[id=select-" + r_id + "]").get(0);
                if (e.target != chk) {
                    chk.checked = !chk.checked;
                }
            });
            $('tr').on("dblclick", function() {
                alert("Handler for `dblclick` called.");
            });

            function openCenteredPopup(url, id, title = 'เปลี่ยน Privilege', width = 500, height = 600) {
                // Calculate the X and Y positions
                const left = (window.screen.width - width) / 2;
                const top = (window.screen.height - height) / 2;
                const queryString = id.map(item => `id[]=${item}`).join('&');
                // Open the popup window
                const popup = window.open(
                    url + '?' + queryString,
                    title,
                    `width=${width}, height=${height}, left=${left}, top=${top}`
                );

                // Focus the new window (optional)
                if (popup) {
                    popup.focus();
                }


                // Check if the popup is closed
                const checkClosed = setInterval(function() {
                    if (popup && popup.closed) {
                        // The popup window is closed
                        clearInterval(checkClosed); // Stop checking
                        location.reload()
                    }
                }, 1000); // Check every second
            }

        });
    </script>
@endsection
