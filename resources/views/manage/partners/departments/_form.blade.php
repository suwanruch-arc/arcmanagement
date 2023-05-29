<div class="row row-cols-1 row-cols-md-2">
    <div class="col">
        <x-input label="Name" name="name" :value="$name" required />
    </div>
    <div class="col">
        <x-input label="Keyword" name="keyword" :value="$keyword" required />
    </div>
</div>
<div class="row">
    <div class="col">
        <x-file-input label="Logo File" name="logo" />
        <div class="text-center">
            @isset($partner)
                {!! Image::show($partner->id, $partner->getTable(), 'logo', [
                    'width' => '100px',
                    'class' => 'img-thumbnail rounded p-1',
                ]) !!}
            @endisset
        </div>
    </div>
</div>
