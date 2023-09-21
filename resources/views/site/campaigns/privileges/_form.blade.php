
<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-select label="Default Code" name="default_code" :src="['qrcode' => 'QR Code', 'barcode' => 'Barcode', 'textcode' => 'Text Code']" :value="$default_code" required />
    </div>
    <div class="col">
        <x-select select2 label="ร้านค้า" name="shop_id" :src="$shop_lists" :value="$shop_id" required />
    </div>
</div>
<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-input label="วันที่เริ่มต้น" name="start_date" :value="$start_date" required />
    </div>
    <div class="col">
        <x-input label="วันที่สิ้นสุด" name="end_date" :value="$end_date" required />
    </div>
</div>

@switch($campaign->template_type)
    @case('STD')
        @include('site.campaigns.privileges._std')
    @break

    @case('CTM')
        @include('site.campaigns.privileges._ctm', ['settings' => $settings])
    @break
@endswitch

<div class="row row-cols-1 row-cols-md-2 mt-3">
    <div class="col">
        <x-select label="สถานะ" name="status" :src="['active' => 'ใช้งาน', 'inactive' => 'ไม่ใช้งาน']" :value="$status" required />
    </div>
</div>
@section('js')
    <script>
        $(function() {
            $('#has_timer').click(function(e) {
                if ($('#has_timer:checked').val() === 'on') {
                    $('#timer_value').prop('readonly', false);
                } else {
                    $('#timer_value').prop('readonly', true);
                }
            });
            $('#start_date').datetimepicker({
                format: 'Y-m-d H:00:00'
            });
            $('#end_date').datetimepicker({
                step: 60,
                format: 'Y-m-d H:59:59'
            });
        });
    </script>
@endsection
