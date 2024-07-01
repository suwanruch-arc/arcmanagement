<div class="mb-3">
    <label for="{{ $id }}" class="form-label">
        {{ $label }}
        @if ($attributes->has('required'))
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="input-group">
        @if ($prepend)
            <span class="input-group-text">{{ $prepend }}</span>
        @endif
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
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
