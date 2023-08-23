<label for="settings" class="form-label">
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
