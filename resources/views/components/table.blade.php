<div>
    <div class="mb-2">
        <button type="button" class="btn btn-sm btn-primary" id="editBtn" onclick="editData()">แก้ไข</button>
        <button type="button" class="btn btn-sm btn-danger" id="delBtn">ลบข้อมูล</button>
    </div>
    <table id="myTable" class="table table-bordered nowrap"> </table>
</div>


@section('js')
    @parent
    <script>
        let table = new DataTable('#myTable', {
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
            dom: '<"row mb-2"<"col d-flex gap-2"fl><"col"p>>rt<"row"<"col"i><"col"p>>',
            aLengthMenu: [
                [10, 25, 50, 100, 200, -1],
                [10, 25, 50, 100, 200, "ทั้งหมด"]
            ],
            iDisplayLength: 25,
            rowCallback: function(row, data) {
                $(row).attr('data-id', data.id);
            },
            initComplete: function() {
                // $('#loading').remove()
                // $('#myTable').show()
            },
        });

        function editData() {
            if ($('#myTable tbody tr.selected').hasClass('selected')) {
                var id = $('tr.selected').attr('data-id');
                console.log(id);
            }
        }
    </script>
@endsection

@section('css')
    @parent
    <style>
        .select-info {
            visibility: hidden;
        }

        tr:first-child th:first-child {
            border-radius: .375rem 0 0 0;
        }

        tr:first-child th:last-child {
            border-radius: 0 .375rem 0 0;
        }

        tr:last-child td:first-child {
            border-radius: 0 0 0 .375rem;
        }

        tr:last-child td:last-child {
            border-radius: 0 0 .375rem 0;
        }

        .dataTables_empty {
            border-radius: 0 0 .375rem .375rem !important;
        }
    </style>
@endsection
