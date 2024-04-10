<div class="row">
    <div class="col-4 border-end">
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
                <x-select :src="[
                    'main' => 'Main',
                    'db_storage_code' => 'DB Storage Code',
                    'db_95' => 'DB 95',
                    'db_a' => 'DB Ecoupon A',
                    'db_b' => 'DB Ecoupon B',
                ]" label="Connection" name="connection" :value="$connection" required />
            </div>
            <div class="col">
                <x-select :src="['std' => 'Standard', 'raw' => 'Raw SQL']" label="Type" name="type_query" :value="$type_query" required />
            </div>
        </div>
        <div class="row row-cols-1">
            <div class="col">
                <x-input label="Name" name="name" :value="$name" required />
            </div>
        </div>
        <div class="row row-cols-1">
            <div class="col">
                <x-input type="area" label="Description" name="description" :value="$description" />
            </div>
        </div>
        <div class="row row-cols-1">
            <div class="col">
                <x-assign-list :selected="$assign_users"  />
            </div>
        </div>
    </div>
    <div class="col-8 border-start">
        <div class="row row-cols-1">
            <div class="col">
                <span id="formStatement">

                </span>
            </div>
        </div>
    </div>
</div>

@section('js')
    <script>
        $(document).ready(function() {
            getTypeForm()
            $('#type_query').change(function(e) {
                e.preventDefault();
                getTypeForm()
            });
        });

        function getTypeForm() {
            const type_query = $('#type_query').val();
            $.ajax({
                type: "GET",
                url: "{{ route('manage.reports.get-form') }}",
                data: {
                    report: '{{ $report_id }}',
                    type_query: type_query
                },
                dataType: "html",
                success: function(response) {
                    $('#formStatement').html(response)
                }
            });
        }

        function addSelectField() {
            $.ajax({
                type: "GET",
                url: "{{ route('manage.reports.get-select-form') }}",
                dataType: "html",
                success: function(response) {
                    $('#formSelect').append(response)
                }
            });
        }

        function removeSelectField(that) {
            let cc = $('#select_count');
            cc.val(parseInt(cc.val() - 1));
            $(that).parent().parent().remove();
        }
    </script>
@endsection

@section('css')
    <style>
        #formSelect>div {
            margin: 5px 0px;
        }

        #formSelect>div:last-child {
            border-bottom: 0 !important;
        }
    </style>
@endsection
