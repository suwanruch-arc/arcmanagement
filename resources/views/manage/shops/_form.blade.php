<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-input label="ชื่อร้าน" name="name" :value="$name" required />
    </div>
    <div class="col">
        <x-input label="คีย์เวิร์ด" name="keyword" :value="$keyword" required />
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-select label="สถานะ" name="status" :src="['active' => 'ใช้งาน', 'inactive' => 'ไม่ใช้งาน']" :value="$status" required />
    </div>
</div>
<div class="row row-cols-1">
    <div class="col">
        <label for="tandc" class="form-label">
            เงื่อนไขและข้อตกลง
        </label>
        <textarea name="tandc" id="tandc">{{ $tandc }}</textarea>
    </div>
</div>

<hr>

<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-file-input label="Template" name="template" />
        {!! Image::show($id, 'shops', [
            'id' => 'template',
            'width' => '100px',
            'class' => 'img-thumbnail rounded p-1',
        ]) !!}
    </div>
    <div class="col">
        <x-file-input label="Banner" name="banner" />
        {!! Image::show($id, 'shops', [
            'id' => 'banner',
            'width' => '100px',
            'class' => 'img-thumbnail rounded p-1',
        ]) !!}
    </div>
</div>
@section('js')
    <script>
        var editor = new FroalaEditor('#tandc', {
            toolbarButtons: [
                [
                    'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript',
                    'clearFormatting', 'fontSize', 'textColor', 'backgroundColor', 'html'
                ],
            ]
        });
    </script>
@endsection
