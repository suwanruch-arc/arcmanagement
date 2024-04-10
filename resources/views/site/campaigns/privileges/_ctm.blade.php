<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-file-input label="Template" name="template" />
        {!! Image::show($id, 'privileges', [
            'id' => 'template',
            'width' => '100px',
            'class' => 'img-thumbnail rounded p-1',
        ]) !!}
    </div>
    <div class="col">
        <x-input class="numberonly" label="ราคา" name="value" :value="$value" append="฿" required />
    </div>
</div>

<label for="settings" class="form-label mt-3">
    ตั้งค่า<span class="text-danger">*</span>
</label>
<div class="row row-cols-1 row-cols-md-5">
    @foreach ($settings as $name => $value)
        <div class="col">
            <x-input :label="$name" name="settings[{{ $name }}]" id="setting-{{ $name }}"
                :value="$value" append="px" />
        </div>
    @endforeach
</div>
