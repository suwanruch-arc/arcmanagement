<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4 p-2 m-0 border-bottom">
    <div class="col">
        <x-input label="Label" name="label[]" id="label-{{ rand(1, 999) }}" required />
    </div>
    <div class="col">
        <x-input label="Feild" name="field[]" id="field-{{ rand(1, 999) }}" required />
    </div>
    <div class="col">
        <x-select label="Condition" name="condition[]" id="is_search-{{ rand(1, 999) }}" :src="[
            'String' => [
                '=' => 'เท่ากับ (=)',
                'LIKE' => 'บางตัว (Like)',
            ],
            'Date' => [
                '>' => 'มากกว่า (>)',
                '>=' => 'มากกว่าเท่ากับ (>=)',
                '<' => 'น้อยกว่า (<)',
                '<=' => 'น้อยกว่าเท่ากับ (<=)',
            ],
        ]" />
    </div>
    <div class="col d-flex align-items-center justify-content-between">
        <x-input type="switch" label="Search" name="is_search[]" id="is_search-{{ rand(1, 999) }}" />
        <button type="button" class="btn btn-outline-danger btn-sm"
            onclick="removeSelectField(this)"><b>ลบ</b></button>
    </div>
</div>
