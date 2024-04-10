<div class="row">
    <div class="col">
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
                <input type="hidden" name="template_type" required value="{{ $template_type }}" />
            </div>
            <div class="col">
                <input type="hidden" name="owner_id" required value="{{ $owner_id }}" />
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <x-input label="ชื่อแคมเปญ" name="name" :value="$name" required />
            </div>
            <div class="col">
                <x-select label="สถานะ" name="status" :src="['active' => 'ใช้งาน', 'inactive' => 'ไม่ใช้งาน']" :value="$status" required />
            </div>
            @if ($type === 'create')
                <div class="col-3">
                    <x-input label="คีย์เวิร์ด" name="keyword" :value="$keyword" required max="3" min="3"
                        class="uppercase" />
                </div>
                @if ($template_type === 'CTMS')
                    <div class="col">
                        <x-select :src="[
                            'db_storage_code' => 'DB Storage Code',
                            'db_a' => 'DB Ecoupon A',
                            'db_b' => 'DB Ecoupon B',
                        ]" label="Connection" name="connection" :value="$connection" required />
                    </div>
                    <div class="col">
                        <x-input label="ชื่อตาราง" name="table_name" required />
                    </div>
                @endif
            @endif
        </div>
        <div class="row row-cols-1 row-cols-md-2 ">
            <div class="col">
                <x-input label="วันที่เริ่มต้น" name="start_date" :value="$start_date" required />
            </div>
            <div class="col">
                <x-input label="วันที่สิ้นสุด" name="end_date" :value="$end_date" required />
            </div>
        </div>
        <div class="row row-cols-1 mb-3">
            <div class="col">
                <label for="description" class="form-label">
                    รายละเอียด
                </label>
                <textarea name="description" class="editor">{{ $description }}</textarea>
            </div>
        </div>
        <div class="row row-cols-1">
            <div class="col">
                <x-assign-list :selected="$assign_users" required />
            </div>
        </div>
    </div>
    @if ($template_type === 'STD')
        <div class="col">
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col">
                    <x-input label="หัวข้อยืนยันรับสิทธิ์" name="settings[alert][title]" :value="$settings->alert->title" required />
                </div>
                <div class="col">
                    <x-input type="area" label="รายละเอียดยืนยันรับสิทธิ์" name="settings[alert][description]"
                        :value="$settings->alert->description" required />
                </div>
                <div class="col">
                    <x-input type="color" label="สี Main" name="settings[color][main]" :value="$settings->color->main" required />
                </div>
                <div class="col">
                    <x-input type="color" label="สี Secondary" name="settings[color][secondary]" :value="$settings->color->secondary"
                        required />
                </div>
                <div class="col">
                    <label for="redeem_btn" class="form-label">
                        ปุ่ม Redeem
                    </label>
                    <div class="input-group mb-3">
                        <div class="input-group-text p-1">
                            <input type="color" name="settings[color][redeem]" value="{{ $settings->color->redeem }}"
                                required />
                        </div>
                        <input type="text" class="form-control" id="redeem_btn" name="settings[button][redeem]"
                            value="{{ $settings->button->redeem }}"></>
                    </div>
                </div>
                <div class="col">
                    <label for="view_btn" class="form-label">
                        ปุ่ม View
                    </label>
                    <div class="input-group mb-3">
                        <div class="input-group-text p-1">
                            <input type="color" name="settings[color][view]" value="{{ $settings->color->view }}"
                                required />
                        </div>
                        <input type="text" class="form-control" id="view_btn" name="settings[button][view]"
                            value="{{ $settings->button->view }}">
                        </>
                    </div>
                </div>
                <div class="col">
                    <label for="already_btn" class="form-label">
                        ปุ่ม Already
                    </label>
                    <div class="input-group mb-3">
                        <div class="input-group-text p-1">
                            <input type="color" name="settings[color][already]"
                                value="{{ $settings->color->already }}" required />
                        </div>
                        <input type="text" class="form-control" id="already_btn" name="settings[button][already]"
                            value="{{ $settings->button->already }}"></>
                    </div>
                </div>
                <div class="col">
                    <label for="expire_btn" class="form-label">
                        ปุ่ม Expire
                    </label>
                    <div class="input-group mb-3">
                        <div class="input-group-text p-1">
                            <input type="color" name="settings[color][expire]"
                                value="{{ $settings->color->expire }}" required />
                        </div>
                        <input type="text" class="form-control" id="expire_btn" name="settings[button][expire]"
                            value="{{ $settings->button->expire }}"></>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@section('js')
    <script>
        $('#start_date').datetimepicker({
            format: 'Y-m-d H:00:00'
        });
        $('#end_date').datetimepicker({
            step: 60,
            format: 'Y-m-d H:59:59'
        });
    </script>
@endsection
