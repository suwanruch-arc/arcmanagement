<div class="col">
    <x-select select2 label="Partner" name="partner_id" required>
        @foreach ($partnerList as $id => $name)
            <option value="{{ $id }}" @if ($id === $partnerValue) selected @endif>
                {{ $name }}
            </option>
        @endforeach
    </x-select>
</div>
<div class="col">
    <x-select select2 label="Department" name="department_id" required>
        @foreach ($departmentList as $partner => $department)
            <optgroup label="{{ $partner }}">
                @foreach ($department as $id => $name)
                    <option value="{{ $id }}" @if ($id === $departmentValue) selected @endif>
                        {{ $name }}
                    </option>
                @endforeach
            </optgroup>
        @endforeach
    </x-select>
</div>
@section('js')
    <script>
        $(document).ready(function() {
            let depHtml = $('#department_id').html();
            $('#partner_id').change(function() {
                let sel_partner = $.trim($('#partner_id :selected').text());
                let dep = $('#department_id');
                dep.html(depHtml);
                if ($('optgroup[label="' + sel_partner + '"]').length > 0) {
                    var optGroup = $('optgroup[label="' + sel_partner + '"]').prop('outerHTML');
                    dep.html(optGroup);
                    $('#department_id').prop('disabled', false).trigger('change');
                } else {
                    dep.html('<option selected disabled value="">Choose...</option>');
                    $('#department_id').prop('disabled', true).trigger('change');
                }
            });
            if ($('#partner_id').find(":selected").val() != '') {
                $('#partner_id').trigger('change');
                $('#department_id').prop('disabled', false);
            } else {
                $('#department_id').prop('disabled', true);
            }
        });
    </script>
@endsection
