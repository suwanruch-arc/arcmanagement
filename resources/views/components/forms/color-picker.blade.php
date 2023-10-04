@if ($label)
    <label for="{{ $name }}" class="form-label">{{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
@endif
<select name="{{ $name }}" id="{{ $id ?? $name }}"
    class="color-picker form-select @if ($size === 'sm') form-select-sm @endif @if ($size === 'lg') form-select-lg  @endif">
    @foreach ($color_list as $hex => $color)
        <option value="{{ $color }}" hex="{{ $hex }}"
            style="background-color: {{ $hex }};color:{{ $color === 'white' ? 'black' : 'white' }};"
            @if ($color === intval($value) || $color === $value) selected @endif>
            {{ $color }}
        </option>
    @endforeach
</select>
