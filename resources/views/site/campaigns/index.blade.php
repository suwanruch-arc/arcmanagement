@extends('layouts.master', ['route' => url()->previous()])

@section('title')
    <h3>Campaigns</h3>
@endsection

@section('content')
    <x-container fluid>
        @if (in_array(auth()->user()->position, ['admin', 'leader']))
            <x-card class="mb-3">
                <x-card-body>
                    <form>
                        <div class="row row-cols-1 row-cols-md-6 justify-content-center align-items-center">
                            @if (auth()->user()->position === 'admin')
                                <div class="col">
                                    <x-select select2 label="Partner" name="partner_id">
                                        @foreach ($partner_lists as $id => $name)
                                            <option value="{{ $id }}"
                                                @if ($id === app('request')->input('partner_id') || $id === intval(app('request')->input('partner_id'))) selected @endif>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </x-select>
                                </div>
                            @endif
                            <div class="col">
                                <x-select select2 label="Department" name="department_id">
                                    @foreach ($department_lists as $partner_name => $department)
                                        <optgroup label="{{ $partner_name }}">
                                            @foreach ($department as $id => $name)
                                                <option value="{{ $id }}"
                                                    @if ($id === app('request')->input('department_id') || $id === intval(app('request')->input('department_id'))) selected @endif>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </x-select>
                            </div>
                            <div class="col">
                                <button class="btn btn-primary " type="submit">
                                    ค้นหา
                                </button>
                                <button class="btn btn-sm btn-link" type="button"
                                    onclick="window.location = window.location.href.split('?')[0]">
                                    ล้าง
                                </button>
                            </div>
                        </div>
                    </form>
                </x-card-body>
            </x-card>
        @endif

        <x-card>
            <x-card-header class="d-flex align-item-center justify-content-between">
                <div class="fs-5">
                    ผู้ใช้งาน
                </div>
                <a href="{{ route('site.campaigns.pre-create') }}"
                    class="ms-2 btn btn-sm btn-primary d-flex align-items-center gap-2">
                    <span class="material-icons-round">add</span>
                    สร้างแคมเปญ
                </a>
            </x-card-header>
            <x-card-body>
                <x-datatable sort>
                    <thead>
                        <tr>
                            <th width="15%">Name</th>
                            <th width="15%">Keyword</th>
                            <th width="15%">Table Name</th>
                            <th width="15%">Template Type</th>
                            <th width="15%">Owner</th>
                            <th width="15%">ระหว่างวันที่</th>
                            <th width="1%">Status</th>
                            <th width="9%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($campaigns as $campaign)
                            <tr>
                                <td>{{ $campaign->name }}</td>
                                <td>{{ $campaign->keyword }}</td>
                                <td>{{ $campaign->table_name }}</td>
                                <td>{{ $campaign->template_type }}</td>
                                <td>{{ $campaign->owner->name }}</td>
                                <td class="fw-bold text-center">
                                    {{ date('d/m/Y H:i', strtotime($campaign->start_date)) }} -
                                    {{ date('d/m/Y H:i', strtotime($campaign->end_date)) }}
                                </td>
                                <td class="text-center align-middle">
                                    {!! Status::show($campaign->status) !!}
                                </td>
                                <td class="text-center">
                                    <x-action-btn :model="$campaign" route="site.campaigns" :params="['campaign' => $campaign->id]">
                                        @if ($campaign->template_type !== 'CTMS')
                                            <x-button label='คลังข้อมูล' color="secondary"
                                                href="{{ route('site.warehouse.index', $campaign->id) }}"
                                                class="m-1 text-nowrap btn-sm">
                                                <i class="material-icons-round fs-6">inventory_2</i>
                                            </x-button>
                                            <x-button label='Privileges' color="info" class="m-1 text-nowrap btn-sm"
                                                href="{{ route('site.campaigns.privileges.index', $campaign->id) }}">
                                                <i class="material-icons-round fs-6">view_agenda</i>
                                            </x-button>
                                        @endif
                                    </x-action-btn>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </x-datatable>
            </x-card-body>
        </x-card>
    </x-container>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            let depHtml = $('#department_id').html();
            $('#partner_id').change(function() {
                let sel_partner = $.trim($('#partner_id :selected').text());
                let dep = $('#department_id');
                dep.html(depHtml);
                if ($('optgroup[label="' + sel_partner + '"]').length > 0) {
                    var optGroup = $('optgroup[label="' + sel_partner + '"]').prop('outerHTML');
                    dep.html(optGroup);
                    $('#department_id').prop('disabled', false).trigger('change');
                } else {
                    dep.html('<option selected disabled value="">กรุณาเลือก...</option>');
                    $('#department_id').prop('disabled', true).trigger('change');
                }
            });

            if ('{{ auth()->user()->position }}' === 'admin') {
                if ($('#partner_id').find(":selected").val() != '') {
                    $('#partner_id').trigger('change');
                    $('#department_id').prop('disabled', false);
                } else {
                    $('#department_id').prop('disabled', true);
                }
            }
        });
    </script>
@endsection
