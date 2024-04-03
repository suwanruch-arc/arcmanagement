@if ($label)
    <label for="{{ $name }}" class="form-label">{{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
@endif
<div class="mb-3">
    <select class="form-select @if ($select2) select2 @endif @error($name) is-invalid @enderror"
        @if ($required) required @endif @if ($multiple) multiple @endif
        name="{{ $name }}" id="{{ $id ?? $name }}">
        <option selected disabled value="">กรุณาเลือก...</option>
        @if (empty($slot->toHtml()))
            @if (count($src) == count($src, COUNT_RECURSIVE))
                @foreach ($src as $key => $item)
                    <option value="{{ $key }}" @if ($key === intval($value) || $key === $value) selected @endif>
                        {!! $item !!}
                    </option>
                @endforeach
            @else
                @foreach ($src as $group => $data)
                    <optgroup label="{{ $group }}">
                        @foreach ($data as $key => $item)
                            <option value="{{ $key }}" @if ($key === intval($value) || $key === $value) selected @endif>
                                {!! $item !!}
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
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
