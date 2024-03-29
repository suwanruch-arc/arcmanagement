<div class="row">
    <div class="col">
        <x-input label="Name" name="name" :value="$name" required />
    </div>
    <div class="col-3">
        <x-input label="Keyword" name="keyword" :value="$keyword" max="10" min="1" required class="uppercase" />
    </div>
    <div class="col-3">
        <x-select label="Status" name="status" :src="['active' => 'ใช้งาน', 'inactive' => 'ไม่ใช้งาน']" :value="$status" required />
    </div>
    <div class="col">
        <x-input label="Logo width" name="logo_width" :value="$logo_width" required />
    </div>
</div>
<div class="row">
    <div class="col">
        <x-file-input label="Logo File" name="logo" />
        <div class="text-center">
            @isset($id)
                {!! Image::show($id, 'departments', [
                    'id' => 'logo',
                    'width' => '100px',
                    'class' => 'img-thumbnail rounded p-1',
                ]) !!}
            @endisset
        </div>
    </div>
</div>
