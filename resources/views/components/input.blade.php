@if ($label)
    <label for="{{ $name }}" class="form-label">{{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
@endif
<div class="input-group mb-3 @error($name) has-validation @enderror">
    @if ($prepend)
        <span class="input-group-text">{{ $prepend }}</span>
    @endif

    <input @if ($required) required @endif type="{{ $type }}" name="{{ $name }}"
        id="{{ $id ?? $name }}" class="form-control @error($name) is-invalid @enderror" value="{{ $value }}"
        placeholder="{{ $placeholder }}" minlength="{{ $min }}" maxlength="{{ $max }}">

    @if ($append)
        <span class="input-group-text">{{ $append }}</span>
    @endif

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
