<div class="mb-3">
    <label
        for="{{ $id }}"
        class="form-label"
    >
        {{ $label }}
        @if ($attributes->has('required'))
            <span class="text-danger">*</span>
        @endif
    </label>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $attributes->class(['is-invalid' => $hasError])->merge(['class' => 'form-control']) }}
        {{ $attributes }}
    />
    @error($name)
        <small class="ps-2 text-danger">
            {!! $errors->first($name) !!}
        </small>
    @enderror
</div>
