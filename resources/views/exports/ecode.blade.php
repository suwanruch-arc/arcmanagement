<table>
    <thead>
        <tr>
            <th>ร้านค้า</th>
            <th>มุลค่า</th>
            <th>Code</th>
            <th>วันหมดอายุ</th>
            <th>ชื่อไฟล์</th>
            <th>path</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($content as $data)
            <tr>
                <td>{{ $data->shop->name }}</td>
                <td>{{ $data->value }}</td>
                <td>{{ $data->code }}</td>
                <td>{{ $data->expire_date }}</td>
                <td>{{ $data->unique }}.jpg</td>
                <td>{{ $data->full_path }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
