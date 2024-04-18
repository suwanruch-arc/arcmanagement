<div class="row row-cols-1">
    <div class="col">
        <x-input label="ชื่อแคมเปญ" name="name" :value="$name" required />
    </div>
    <div class="col">
        <label for="description" class="form-label">
            รายละเอียด
        </label>
        <textarea name="description" class="form-control mb-3" rows="5">{{ $description }}</textarea>
    </div>
    <div class="col">
        <label for="owner" class="form-label">Partner / Department <span class="text-danger">*</span></label>
        <select class="select2 form-select" id="owner" name='owner_id' required>
            <option value="0" selected disabled="disabled">กรุณาเลือก</option>
            @forelse ($owner_lists as $partner=>$departments)
                <optgroup label="{{ $partner }}">
                    @forelse ($departments as $id => $name)
                        <option value="{{ $id }}" @if ($id == $owner_id) selected @endif>
                            {{ $name }}</option>
                    @empty
                        <option value disabled>ไม่พบข้อมูล</option>
                    @endforelse
                </optgroup>
            @empty
                <option value disabled>ไม่พบข้อมูล</option>
            @endforelse
        </select>
    </div>
</div>
