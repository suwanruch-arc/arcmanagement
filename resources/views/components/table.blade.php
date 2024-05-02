<div>
    {{-- <x-card>
        <x-card.header class="justify-content-between pe-2">
            <div class="fs-5">
                {{ $label }}
            </div>
            <div class="d-flex justify-content-end gap-2 ">
                <button type="button" class="btn btn-warning" id="editBtn" onclick="editData()"
                    style="display: none;">แก้ไข</button>
                <button type="button" class="btn btn-danger" id="deactiveBtn" onclick="deactiveData()"
                    style="display: none;">ปิดการใช้งาน</button>
                <a type="button" class="btn btn-primary" id="createBtn" href="/{{ $path }}/create">เพิ่ม</a>
            </div>
        </x-card.header>
        <x-card.body>
            <table id="myTable" class="table table-bordered nowrap"></table>
        </x-card.body>
    </x-card> --}}
    <table id="myTable" class="table table-bordered nowrap"></table>
</div>


@section('js')
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
            ordering: false,
            language: {
                url: "{{ asset('plugins/DataTables/th.json') }}",
            },
            dom: '<"row"<"col d-flex gap-2"fl><"col">><"row"<"col"i><"col"p>>rt<"row"<"col"i><"col"p>>',
            aLengthMenu: [
                [10, 25, 50, 100, 200, -1],
                [10, 25, 50, 100, 200, "ทั้งหมด"]
            ],
            iDisplayLength: 25,
            rowCallback: function(row, data) {
                $(row).attr('data-id', data.id).attr('data-status', data.status);
            },
            initComplete: function() {
                // $('#loading').remove()
                // $('#myTable').show()
            },
        });

        table.on('select', function(e) {
            const btn = $('#myTable tbody tr.selected');
            if (btn.hasClass('selected')) {
                var status = btn.attr('data-status');
                if (status !== 'inactive') {
                    $('#deactiveBtn').show();
                }
            }
            $('#editBtn').show();
        });

        table.on('deselect', function(e) {
            $('#editBtn').hide();
            $('#deactiveBtn').hide();
        });


        function editData() {
            const btn = $('#myTable tbody tr.selected');
            if (btn.hasClass('selected')) {
                var id = btn.attr('data-id');
                window.location = '/{!! $path !!}/' + id + '/edit';
            }
        }

        function deactiveData() {
            const btn = $('#myTable tbody tr.selected');
            if (btn.hasClass('selected')) {
                var id = btn.attr('data-id');
                Swal.fire({
                    title: 'คุณแน่ใจใช่ไหม?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'ปิดการใช้งาน',
                    cancelButtonText: 'ย้อนกลับ',
                    focusConfirm: false,
                    focusCancel: true,
                    showClass: {
                        popup: "animate__animated animate__headShake animate__faster"
                    },
                }).then((action) => {
                    if (action.isConfirmed) {
                        $.ajax({
                            url: "/{!! $path !!}/" + id,
                            type: 'DELETE',
                            dataType: "JSON",
                            data: {
                                "id": id,
                                "_token": '{{ csrf_token() }}',
                            },
                            success: function(res) {
                                swal.fire({
                                    icon: 'success',
                                    title: 'การแจ้งเตือน',
                                    html: res.message,
                                    confirmButtonColor: "#0D6EFD",
                                })
                                table.rows().deselect();
                                table.ajax.reload();

                            }
                        });
                    }
                })
            }
        }
    </script>
    @parent
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
