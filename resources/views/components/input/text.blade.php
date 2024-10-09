<div class="mb-3">
    @if ($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if ($attributes->has('required'))
                <span class="text-danger">*</span>
            @endif
            <span style="font-size:12px">
                @if ($attributes->has('min'))
                    <small>min : {{ $attributes->get('min') }}</small>
                @endif
                @if ($attributes->has('max'))
                    <small>max : {{ $attributes->get('max') }}</small>
                @endif
            </span>
        </label>
    @endif
    <div class="input-group">
        @if ($prepend)
            <span class="input-group-text">{{ $prepend }}</span>
        @endif
        @if ($type === 'area')
            <textarea class="form-control" name="{{ $name }}" id="{{ $id }}"
                rows="{{ $attributes->get('rows') ?? 3 }}"
                {{ $attributes->class(['is-invalid' => $hasError])->merge(['class' => 'form-control']) }} {{ $attributes }}>{{ $value }}</textarea>
        @else
            <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
                value="{{ $value }}"
                {{ $attributes->class(['is-invalid' => $hasError])->merge(['class' => 'form-control']) }}
                minlength="{{ $attributes->get('min') }}" maxlength="{{ $attributes->get('max') }}"
                {{ $attributes }} />
        @endif
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
