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
    <select
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $attributes->has('multiple') ? 'multiple' : null }}
        {{ $attributes->class(['is-invalid' => $hasError])->merge(['class' => 'form-select ']) }}
        {{ $attributes }}
    >
        @if (!$attributes->has('multiple') && $placeholder)
            <option
                value
                disabled
                selected
            >
                {{ $placeholder }}
            </option>
        @endif
        @if (empty($slot->toHtml()))
            @if (count($options) == count($options, COUNT_RECURSIVE))
                @foreach ($options as $value => $label)
                    <option
                        value="{{ $value }}"
                        {{ $value == $selected ? 'selected' : '' }}
                    >
                        {{ $label }}
                    </option>
                @endforeach
            @else
                @foreach ($options as $group => $data)
                    <optgroup label="{{ $group }}">
                        @foreach ($data as $value => $label)
                            <option
                                value="{{ $value }}"
                                {{ $label == $selected ? 'selected' : '' }}
                            >
                                {!! $label !!}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            @endif
        @else
            {{ $slot }}
        @endif
    </select>
    @error($name)
        <small class="ps-2 text-danger">
            {!! $errors->first($name) !!}
        </small>
    @enderror
</div>

@section('style')
    <style>
        .is-invalid~.select2 .select2-selection__rendered {
            border: 1px solid red;
            border-radius: var(--bs-border-radius) !important;
        }

        .select2-selection,
        .select2-dropdown {
            border: var(--bs-border-width) solid var(--bs-border-color) !important;
        }

        .select2-container .select2-results__option,
        .select2-container .select2-selection .select2-selection__rendered {
            padding: 0.375rem 2.25rem 0.375rem 0.75rem !important;
        }

        .select2-container .select2-selection {
            height: auto !important;
        }

        .select2-container--default {
            border-radius: var(--bs-border-radius) !important;
        }

        .select2-selection__arrow {
            top: 10px !important;
        }
    </style>
@endsection
