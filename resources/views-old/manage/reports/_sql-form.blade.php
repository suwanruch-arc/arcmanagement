<table class="table table-bordered" width="100%">
    <tbody>
        <tr>
            <th class="text-center align-middle">SQL</th>
            <td colspan="2">
                <x-input type="area" class="editor" name="sql" :value="$sql" placeholder="SELECT * FROM table_name"/>
            </td>
        </tr>
        <tr>
            <th class="text-center">Column</th>
            <th width="85%" id="formSelect"></th>
            <th class="text-center">
                <button role="button" type="button" class="btn btn-sm btn-outline-primary" onclick="addSelectField()">
                    <b>+</b>
                </button>
            </th>
        </tr>
    </tbody>
</table>
