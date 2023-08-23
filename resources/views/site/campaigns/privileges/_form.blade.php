<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-input label="ชื่อ" name="title" :value="$title" required />
    </div>
    <div class="col">
        <x-input class="numberonly" label="ราคา" name="value" :value="$value" append="฿" required />
    </div>
</div>
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
<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-input type="number" min="60" label="จับเวลา" name="timer_value" :value="$timer_value" append="วินาที"
            :readonly="$has_timer === 'no'">
            <x-slot name="prepend">
                <x-input type="switch" name="has_timer" :value="$has_timer === 'yes'" />
            </x-slot>
        </x-input>
    </div>
    <div class="col">
        <label for="can_view" class="form-label">สามารถย้อนกลับมาดูได้</label>
        <x-input type="switch" class="fs-5 ms-1" name="can_view" :value="$can_view" />
    </div>
</div>
<div class="row row-cols-1">
    <div class="col">
        <x-input type="area" label="คำอธิบาย" name="description" :value="$description" />
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
