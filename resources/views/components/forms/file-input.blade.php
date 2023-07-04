<div class="mb-3">
    @if ($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}
            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    <input @if ($required) required @endif class="form-control" type="file" name="{{ $name }}"
        id="{{ $id ?? $name }}">
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

</div>
