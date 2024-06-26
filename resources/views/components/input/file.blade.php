<div class="mb-3">
    <label for="{{ $id }}" class="form-label">
        {{ $label }}
        @if ($attributes->has('required'))
            <span class="text-danger">*</span>
        @endif
    </label>
    <input class="form-control" type="file" name="{{ $name }}" id="{{ $id }}"
        {{ $attributes->class(['is-invalid' => $hasError])->merge(['class' => 'form-control']) }} {{ $attributes }} />
    @error($name)
        <small class="ps-2 text-danger">
            {!! $errors->first($name) !!}
        </small>
    @enderror
    <div class="mt-3" id="image-preview-{{ $id }}">
        @if ($path)
            <img src="{{ $path }}" alt="Image Preview" class="img-thumbnail"
                style="max-width: 100%; height: auto;">
        @endif
    </div>
</div>

@section('script')
    @parent
    <script>
        $('#{{ $id }}').on('change', function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview-{{ $id }}').html('<img src="' + e.target.result +
                        '" alt="Image Preview" class="img-thumbnail" style="max-width: 100%; height: auto;">'
                    );
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
