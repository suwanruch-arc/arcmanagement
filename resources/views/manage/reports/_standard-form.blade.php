<table class="table table-bordered" width="100%">
    <tbody>
        <tr>
            <th class="text-center">Table <span class="text-danger">*</span></th>
            <td colspan="2">
                <x-input name="from" required :value="$report->from ?? null" placeholder='Table Name'/>
            </td>
        </tr>
        <tr>
            <th class="text-center">Where</th>
            <td colspan="2">
                <x-input name="where" :value="$report->where ?? ''" />
            </td>
        </tr>
        <tr>
            <th class="text-center">Column</th>
            <th width="85%" id="formSelect">
                @if ($report)
                    @foreach ($report->settings as $item)
                        @include('manage.reports._select-form', [
                            '_id' => $item->id,
                            'label' => $item->label,
                            'field' => $item->field,
                            'condition' => $item->condition,
                            'is_search' => $item->is_search,
                        ])
                    @endforeach
                @endif
            </th>
            <th class="text-center">
                <button role="button" type="button" class="btn btn-sm btn-outline-primary p-1"
                    onclick="addSelectField()">
                    <b data-feather="plus"></b>
                </button>
            </th>
        </tr>
    </tbody>
</table>

<script>
    feather.replace({
        'aria-hidden': 'true'
    })
</script>
