<div class="row">
    <div class="col-md-6">
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
                <x-select label="ประเภท" name="template_type" :src="['STD' => 'Standard Template', 'CTM' => 'Custom Template']" :value="$template_type" required />
            </div>
            <div class="col">
                <x-select label="Owner" name="owner_id" :src="$owner_lists" :value="$owner_id" required />
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
                <x-input label="ชื่อแคมเปญ" name="name" :value="$name" required />
            </div>
            @if ($type === 'create')
                <div class="col">
                    <x-input label="คีย์เวิร์ด" name="keyword" :value="$keyword" required max="3" min="3"
                        class="uppercase" />
                </div>
            @endif
        </div>
        <div class="row row-cols-1">
            <div class="col">
                <label for="description" class="form-label">
                    รายละเอียด
                </label>
                <textarea name="description" class="editor">{{ $description }}</textarea>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 mt-3">
            <div class="col">
                <x-input label="วันที่เริ่มต้น" name="start_date" :value="$start_date" required />
            </div>
            <div class="col">
                <x-input label="วันที่สิ้นสุด" name="end_date" :value="$end_date" required />
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
                <x-select label="สถานะ" name="status" :src="['active' => 'ใช้งาน', 'inactive' => 'ไม่ใช้งาน']" :value="$status" required />
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
                <x-input label="หัวข้อยืนยันรับสิทธิ์" name="title_alert" :value="$title_alert" required />
            </div>
            <div class="col">
                <x-input type="area" label="รายละเอียดยืนยันรับสิทธิ์" name="desc_alert" :value="$desc_alert"
                    required />
            </div>
            <div class="col">
                <x-input type="color" label="สี Main" name="main_color" :value="$main_color" required />
            </div>
            <div class="col">
                <x-input type="color" label="สี Secondary" name="secondary_color" :value="$secondary_color" required />
            </div>
            <div class="col">
                <label for="redeem_btn" class="form-label">
                    ปุ่ม Redeem
                </label>
                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="color" name="redeem_color" value="{{ $redeem_color }}" required />
                    </div>
                    <input type="text" class="form-control" id="redeem_btn" name="redeem_btn"
                        value="{{ $redeem_btn }}"></>
                </div>
            </div>
            <div class="col">
                <label for="view_btn" class="form-label">
                    ปุ่ม View
                </label>
                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="color" name="view_color" value="{{ $view_color }}" required />
                    </div>
                    <input type="text" class="form-control" id="view_btn" name="view_btn"
                        value="{{ $view_btn }}"></>
                </div>
            </div>
            <div class="col">
                <label for="expire_btn" class="form-label">
                    ปุ่ม Expire
                </label>
                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="color" name="expire_color" value="{{ $expire_color }}" required />
                    </div>
                    <input type="text" class="form-control" id="expire_btn" name="expire_btn"
                        value="{{ $expire_btn }}"></>
                </div>
            </div>
            <div class="col">
                <label for="already_btn" class="form-label">
                    ปุ่ม Already
                </label>
                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input type="color" name="already_color" value="{{ $already_color }}" required />
                    </div>
                    <input type="text" class="form-control" id="already_btn" name="already_btn"
                        value="{{ $already_btn }}"></>
                </div>
            </div>
        </div>

        <div class="row row-cols-1">
            <div class="col">
                <x-assign-list :selected="$assign_users" required />
            </div>
        </div>

    </div>
</div>

@section('js')
    <script>
        $(document).ready(function() {
            $('.color-picker').trigger('change');
        });
        $('.color-picker').change(function(e) {
            const hex = $(this).find(':selected').attr('hex')
            $(this).parent().css('background-color', hex);
        });
        $('#start_date').datetimepicker({
            format: 'Y-m-d H:00:00'
        });
        $('#end_date').datetimepicker({
            step: 60,
            format: 'Y-m-d H:59:59'
        });
    </script>
@endsection
