<div>
    <table id="myTable" class="table table-bordered nowrap"> </table>
</div>


@section('js')
    @parent
    <script>
        let dataTable = new DataTable('#myTable', {
            columns: {!! json_encode($columns) !!},
            select: true,
            ajax: '',
            processing: true,
            serverSide: true,
            autoWidth: false,
            orderCellsTop: true,
            fixedHeader: true,
            responsive: true,
            order: [],
            ordering: true,
            language: {
                url: "{{ asset('plugins/DataTables/th.json') }}",
            },
            dom: '<"row mb-2"<"col d-flex gap-2"l><"col"f>>rt<"row"<"col"i><"col"p>>',
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "ทั้งหมด"]
            ],
            iDisplayLength: 25,
            initComplete: function() {
                // $('#loading').remove()
                // $('#myTable').show()
            },
        });
    </script>
@endsection

@section('css')
    @parent
    <style>
        /* Apply border radius to first row first column */
        tr:first-child th:first-child {
            border-radius: .375rem 0 0 0;
        }

        /* Apply border radius to first row last column */
        tr:first-child th:last-child {
            border-radius: 0 .375rem 0 0;
        }

        /* Apply border radius to last row first column */
        tr:last-child td:first-child {
            border-radius: 0 0 0 .375rem;
        }

        /* Apply border radius to last row last column */
        tr:last-child td:last-child {
            border-radius: 0 0 .375rem 0;
        }

        .dataTables_empty {
            border-radius: 0 0 .375rem .375rem !important;
        }
    </style>
@endsection
