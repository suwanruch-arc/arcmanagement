<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-select label="ประเภท" name="template_type" :src="['STD' => 'Standard Template','CTM' => 'Custom Template']" :value="$template_type" required />
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
            <x-input label="คีย์เวิร์ด" name="keyword" :value="$keyword" required max="3" min="3" />
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

<div class="row row-cols-1">
    <div class="col">
        <x-assign-list :selected="$assign_users" required />
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-select label="สถานะ" name="status" :src="['active' => 'ใช้งาน', 'inactive' => 'ไม่ใช้งาน']" :value="$status" required />
    </div>
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
