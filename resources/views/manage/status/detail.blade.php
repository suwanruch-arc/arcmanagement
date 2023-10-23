<p>{!! str_replace('ปิดการใช้งาน', '<span class="text-danger"><i> ปิดการใช้งาน </i></span>', $title) !!}</p>
@if ($data)
    <table class="table" width="100%">
        <thead>
            <tr>
                <th width="50%">ตาราง</th>
                <th width="50%">จำนวนข้อมูล</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $table => $item)
                <tr>
                    <td class="text-center">{{ $table }}</td>
                    <td class="text-center">
                        {{ $item->count() }}
                        <input name="{{ $table }}" id="disable-id" value="{{ $item }}" type="hidden" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">ไม่มีข้อมูลที่เกี่ยวข้อง</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endif
<input name="main_id" id="main_id" value="{{ $main->id }}" type="hidden" />
<input name="main_table" id="main_table" value="{{ $main->table }}" type="hidden" />
<style>
    .swal2-confirm {
        animation: headShake;
        animation-iteration-count: infinite;
        animation-duration: 1s;
    }
</style>
