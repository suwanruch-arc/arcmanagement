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
        <label for="skip_confirm" class="form-label">ข้ามกดรับสิทธิ์</label>
        <x-input type="switch" class="fs-5 ms-1" name="skip_confirm" :value="$skip_confirm" />
    </div>
    <div class="col">
        <label for="can_view" class="form-label">สามารถย้อนกลับมาดูได้</label>
        <x-input type="switch" class="fs-5 ms-1" name="can_view" :value="$can_view" />
    </div>
    <div class="col">
        <x-input type="number" min="5" label="จับเวลา" name="timer_value" :value="$timer_value" append="นาที"
            :readonly="!$has_timer">
            <x-slot name="prepend">
                <x-input type="switch" name="has_timer" :value="$has_timer" />
            </x-slot>
        </x-input>
    </div>
</div>

<div class="row row-cols-1">
    <div class="col">
        <x-input type="area" label="คำอธิบาย" name="description" :value="$description" />
    </div>
</div>
<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-input type="switch" label="รายละเอียด" name="has_detail" :value="$has_detail" />
        <x-input type="area" class="editor" name="detail" :value="$detail" />
    </div>
    <div class="col">
        <x-input type="switch" label="เงื่อนไขการใช้งาน" name="has_tandc" :value="$has_tandc" />
        <x-input type="area" class="editor" name="tandc" :value="$tandc" />
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 ">
    <div class="col">
        <x-file-input label="Banner" name="banner" />
        {!! Image::show($id, 'privileges', [
            'id' => 'banner',
            'width' => '100px',
            'class' => 'img-thumbnail rounded p-1',
        ]) !!}
    </div>
</div>
