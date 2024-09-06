<div class="mb-3">
    @if ($attributes->has('label'))
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if ($attributes->has('required'))
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    <div class="input-group">
        @if ($prepend)
            <span class="input-group-text">{{ $prepend }}</span>
        @endif
        <input type="{{ $type }}" @if ($attributes->has('name')) name="{{ $name }}" @endif
            id="{{ $id }}"
            {{ $attributes->class(['is-invalid' => $hasError])->merge(['class' => 'form-control']) }}
            {{ $attributes }} />
        @if ($append)
            <span class="input-group-text">{{ $append }}</span>
        @endif
    </div>
    @error($name)
        <small class="ps-2 text-danger">
            {!! $errors->first($name) !!}
        </small>
    @enderror
</div>
