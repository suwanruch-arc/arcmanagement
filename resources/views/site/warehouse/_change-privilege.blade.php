@extends('layouts.blank')

@section('content')
    <div class="card m-2">
        <div class="card-body">
            <x-form method="POST" action="{{ route('site.warehouse.save-change', $campaign->id) }}">
                <input type="hidden" name="id" value="{{ $id }}" />
                <table class="table table-bordered" id="table-privilege">
                    <thead>
                        <tr>
                            <th width=1>

                            </th>
                            <th>
                                ชื่อ
                            </th>
                            <th>
                                ราคา
                            </th>
                            <th>
                                วันหมดอายุ
                            </th>
                            <th>
                                Banner/Template
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($privileges as $privilege)
                            <tr data-id="{{ $privilege->id }}">
                                <td class="text-center align-middle">
                                    <input required class="form-check-input" type="radio" value="{{ $privilege->id }}"
                                        id="select-{{ $privilege->id }}" name="select" />
                                </td>
                                <td>
                                    {{ $privilege->title }}
                                </td>
                                <td>
                                    {{ $privilege->value }}
                                </td>
                                <td>
                                    {{ $privilege->end_date }}
                                </td>
                                <td>
                                    @switch($campaign->template_type)
                                        @case('STD')
                                            {!! Image::show($privilege->id, 'privileges', [
                                                'id' => 'banner',
                                                'width' => '100px',
                                                'class' => 'img-thumbnail rounded p-1',
                                            ]) !!}
                                        @break

                                        @case('CTMT')
                                            {!! Image::show($privilege->id, 'privileges', [
                                                'id' => 'template',
                                                'width' => '100px',
                                                'class' => 'img-thumbnail rounded p-1',
                                            ]) !!}
                                        @break
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </x-form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $("tr").on('click', function(e) {
            const r_id = $(this).attr("data-id");
            var chk = $(this).closest("tr").find("input:radio[id=select-" + r_id + "]").get(0);
            if (e.target != chk) {
                chk.checked = !chk.checked;
            }
        });

        $('#table-privilege').dataTable({
            columnDefs: [{
                orderable: false,
                targets: 0
            }],
            order: [
                [1, 'asc']
            ]
        })
    </script>
@endsection
