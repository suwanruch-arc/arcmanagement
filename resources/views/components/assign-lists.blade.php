<div class="mb-3">
    <label for="description" class="form-label">
        มอบหมายให้
    </label>
    <div id="loading" style="display: block;height: 59px;" class="text-body-secondary fst-italic">
        <small>กำลังโหลดข้อมูล...</small>
    </div>
    <div class="mb-2" id="assign-lists-area" style="display: none;">
        <select class="form-select select2" name="assigns[]" id="assign_lists" multiple>
            @foreach ($partners as $partner)
                <optgroup label="{{ $partner->name }}">
                    @foreach ($partner->users as $user)
                        @if ($user->department)
                            <option partner="{{ $partner->id }}" department="{{ $user->department->id }}"
                                value="{{ $user->id }}" @if (!is_null($selected) && in_array($user->id, $selected)) selected @endif>
                                {{ $user->department->name ?? 'None' }} - {{ $user->name }}
                            </option>
                        @endif
                    @endforeach
                </optgroup>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <span role="button" class="badge text-bg-primary mb-1" onclick="selectAll()">All</span>
        @foreach ($partners as $partner)
            <span role="button" class="badge text-bg-secondary mb-1"
                onclick="selectOwner('{{ $partner->id }}','partner')">{{ $partner->name }}</span>
            @foreach ($partner->departments as $department)
                <span role="button" class="badge text-bg-light border mb-1"
                    onclick="selectOwner('{{ $department->id }}','department')">
                    {{ $department->name }}
                </span>
            @endforeach
        @endforeach
        <span role="button" class="badge text-bg-danger mb-1" onclick="clearOwner()">X</span>
    </div>
</div>

@section('script')
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

        $(document).ready(function() {
            $('div#loading').hide();
            $('div#assign-lists-area').show();
        })
    </script>
    @parent
@endsection
