@if ($type === 'switch')
    <div class="form-check form-switch {{ $class }}">
        <input class="form-check-input" type="checkbox" role="switch" id="{{ $id ?? $name }}" name="{{ $name }}"
            @if ($value) checked @endif>
        <label class="form-check-label" for="{{ $id ?? $name }}">{{ $label }}</label>
    </div>
@else
    @if ($label)
        <label for="{{ $id ?? $name }}" class="form-label">{{ $label }}
            @if ($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    <div class="input-group mb-3">
        @if ($type === 'area')
            <textarea class="form-control {{ $class }}  @error($name) is-invalid @enderror" name="{{ $name }}"
                id="{{ $id ?? $name }}" rows="3">{{ $value }}</textarea>
        @elseif ($type === 'color')
            <input type="color" class="form-control form-control-color" name="{{ $name }}"
                id="{{ $id ?? $name }}" value="#563d7c">
        @else
            @if ($prepend)
                <span class="input-group-text">{{ $prepend }}</span>
            @endif

            <input @if ($disabled) disabled @endif @if ($readonly) readonly @endif
                @if ($required) required @endif type="{{ $type }}"
                name="{{ $name }}" id="{{ $id ?? $name }}"
                class="form-control @error($name) is-invalid @enderror @if ($readonly) readonly @endif {{ $class }}"
                value="{{ $value }}" placeholder="{{ $placeholder }}" min="{{ $min }}"
                minlength="{{ $min }}" max="{{ $max }}" maxlength="{{ $max }}">

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
