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
</div>
@if ($type === 'create')
    <div class="row row-cols-1 row-cols-md-2">
        <div class="col">
            <x-input label="Department Name" name="department_name" :value="$department_name" />
        </div>
        <div class="col">
            <x-input label="Department Keyword" name="department_keyword" max="10" min="1"
                :value="$department_keyword" class="uppercase" />
        </div>
    </div>
@endif
<div class="row">
    <div class="col">
        <x-file-input label="Logo File" name="logo" />
        <div class="text-center">
            @isset($partner)
                {!! Image::show($partner->id, $partner->getTable(), [
                    'id' => 'logo',
                    'width' => '100px',
                    'class' => 'img-thumbnail rounded p-1',
                ]) !!}
            @endisset
        </div>
    </div>
</div>
