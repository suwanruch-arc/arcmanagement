@if ($type === 'switch')
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="{{ $id ?? $name }}" name="{{ $name }}"
            @if ($value) checked @endif>
        <label class="form-check-label" for="{{ $id ?? $name }}">{{ $label ?? 'Switch' }}</label>
    </div>
@else
    @if ($label)
        <label for="{{ $id ?? $name }}" class="form-label">{{ $label }}
            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    <div class="input-group mb-3  @error($name) was-validated @enderror">
        @if ($type === 'area')
            <textarea class="form-control" name="{{ $name }}" id="{{ $id ?? $name }}" rows="3">{{ $value }}</textarea>
        @else
            @if ($prepend)
                <span class="input-group-text">{{ $prepend }}</span>
            @endif

            <input @if ($required) required @endif type="{{ $type }}"
                name="{{ $name }}" id="{{ $id ?? $name }}"
                class="form-control @error($name) is-invalid @enderror" value="{{ $value }}"
                placeholder="{{ $placeholder }}" minlength="{{ $min }}" maxlength="{{ $max }}">

            @if ($append)
                <span class="input-group-text">{{ $append }}</span>
            @endif
        @endif

        @error($name)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

@endif
