<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-input type="switch" label="รายละเอียด" name="has_detail" :value="$has_detail === 'yes'" />
        <x-input type="area" class="editor" name="detail" :value="$detail" />
    </div>
    <div class="col">
        <x-input type="switch" label="เงื่อนไขการใช้งาน" name="has_tandc" :value="$has_tandc === 'yes'" />
        <x-input type="area" class="editor" name="tandc" :value="$tandc" />
    </div>
</div>
<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-file-input label="Banner" name="banner" />
        {!! Image::show($id, 'privileges', [
            'id' => 'banner',
            'width' => '100px',
            'class' => 'img-thumbnail rounded p-1',
        ]) !!}
    </div>
</div>
