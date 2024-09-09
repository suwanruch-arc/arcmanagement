<div class="mb-3">
    @if ($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if ($attributes->has('required'))
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    <select name="{{ $name }}" id="{{ $id }}" {{ $attributes->has('multiple') ? 'multiple' : null }}
        {{ $attributes->class(['is-invalid' => $hasError])->merge(['class' => 'form-select ']) }} {{ $attributes }}>
        @if (!$attributes->has('multiple') && $placeholder)
            <option value disabled selected>
                {{ $placeholder }}
            </option>
        @endif
        @if (empty($slot->toHtml()))
            @if (count($options) == count($options, COUNT_RECURSIVE))
                @foreach ($options as $value => $label)
                    <option value="{{ $value }}" {{ $value == $selected ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            @else
                @foreach ($options as $group => $data)
                    <optgroup label="{{ $group }}">
                        @foreach ($data as $value => $label)
                            <option value="{{ $value }}" {{ $value == $selected ? 'selected' : '' }}>
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
