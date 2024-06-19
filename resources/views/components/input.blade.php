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
        {{ $attributes->merge(['class' => 'form-control']) }}
        {{ $attributes }}
    />
</div>
