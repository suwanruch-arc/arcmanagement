<table class="table table-bordered" width="100%">
    <tbody>
        <tr>
            <th class="text-center">FROM <span class="text-danger">*</span></th>
            <td colspan="2">
                <x-input name="from" required />
            </td>
        </tr>
        <tr>
            <th class="text-center">WHERE</th>
            <td colspan="2">
                <x-input name="where" />
            </td>
        </tr>
        <tr>
            <th class="text-center">SELECT</th>
            <th width="85%" id="formSelect">

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
