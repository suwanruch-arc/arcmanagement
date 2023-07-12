<label for="assign_lists" class="form-label">Assign Lists
    @if ($required)
        <span class="text-danger">*</span>
    @endif
</label>
<div class="mb-1">
    <select class="form-control select2" name="assign_lists[]" id="assign_lists" multiple
        @if ($required) required @endif>
        @foreach ($partners as $partner)
            <optgroup label="{{ $partner->name }}">
                @foreach ($partner->users as $user)
                    <option partner="{{ $partner->keyword }}" department="{{ $user->department->keyword }}"
                        value="{{ $user->id }}" @if (in_array($user->id, $selected)) selected @endif>
                        {{ $user->department->name ?? 'None' }} - {{ $user->name }}
                    </option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <span role="button" class="badge text-bg-primary" onclick="selectAll()">All</span>
    @foreach ($partners as $partner)
        <span role="button" class="badge text-bg-secondary"
            onclick="selectOwner('{{ $partner->keyword }}','partner')">{{ $partner->name }}</span>
        @foreach ($partner->departments as $department)
            <span role="button" class="badge text-bg-light border"
                onclick="selectOwner('{{ $department->keyword }}','department')">
                {{ $department->name }}
            </span>
        @endforeach
    @endforeach
    <span role="button" class="badge text-bg-danger" onclick="clearOwner()">X</span>
</div>

<script>
    function selectAll() {
        $("#assign_lists")
            .find("option")
            .each(function() {
                $(this).prop("selected", "selected");
            });
        $("#assign_lists").trigger("change");
    }

    function selectOwner(partdep, type) {
        switch (type) {
            case "partner":
                $('[partner="' + partdep + '"]').each(function() {
                    $(this).prop("selected", true);
                });
                $("#assign_lists").trigger("change");
                break;
            case "department":
                $('[department="' + partdep + '"]').each(function() {
                    $(this).prop("selected", true);
                });
                $("#assign_lists").trigger("change");
                break;
        }
    }

    function clearOwner() {
        $("#assign_lists").val(null).trigger("change");
    }
</script>
