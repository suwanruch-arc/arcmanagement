<div class="row">
    <div class="col-4 border-end">
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
                <x-select :src="['mysql' => 'Main', 'db_95' => 'DB 95', 'db_a' => 'DB Ecoupon A', 'db_b' => 'DB Ecoupon B']" label="Connection" name="connection" :value="$connection" required />
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
                <x-assign-list :selected="$assign_users" />
            </div>
        </div>
    </div>
    <div class="col-8 border-start">
        <div class="row row-cols-1">
            <div class="col">
                <table class="table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th width="85%"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-center align-middle">SELECT</td>
                            <td id="fieldArea">b</td>
                            <td class="text-center align-middle">
                                <button onclick="addSelectField()" type="button"
                                    class="btn btn-sm btn-outline-primary">
                                    <span data-feather="plus"></span>
                                </button>
                            </td>
                        </tr>
                        <tr id="stdArea">
                            <th>FROM</th>
                        </tr>
                        <tr id="stdArea">
                            <th>WHERE</th>
                        </tr>
                        <tr id="sqlArea">
                            <th>SQL</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@section('js')
    <script>
        $(document).ready(function() {
            $('#type_query').change(function() {
                switch (this.value) {
                    case 'std':
                        $('[id=stdArea]').show();
                        $('#sqlArea').hide();
                        break;
                    case 'raw':
                        $('[id=stdArea]').hide();
                        $('#sqlArea').show();
                        break;
                }
            });
        });

        function addSelectField() {
            alert('123')
        }
    </script>
@endsection
