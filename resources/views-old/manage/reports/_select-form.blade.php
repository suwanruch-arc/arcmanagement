@php
    $rand = $_id ?? rand(1111, 9999);
@endphp
<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4 p-2 m-0 border-bottom">
    <div class="col">
        <x-input label="Label" name="selects[{{ $rand }}][label]" id="label-{{ $rand }}" required
            :value="$label ?? ''" />
    </div>
    <div class="col">
        <x-input label="Feild" name="selects[{{ $rand }}][field]" id="field-{{ $rand }}" required
            :value="$field ?? ''" />
    </div>
    <div class="col">
        <x-select label="Condition" name="selects[{{ $rand }}][condition]" id="condition-{{ $rand }}"
            :value="$condition ?? ''" :src="[
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
        <x-input type="switch" label="Search" name="selects[{{ $rand }}][is_search]"
            id="is_search-{{ $rand }}" :value="isset($is_search) && $is_search === 'yes' ? true : false" />
        <button type="button" class="btn btn-outline-danger btn-sm"
            onclick="removeSelectField(this)"><b>ลบ</b></button>
    </div>
</div>
