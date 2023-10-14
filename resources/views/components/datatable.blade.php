@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="fs-4" id="loading">
    <div class="d-flex justify-content-center">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>&nbsp;
        กำลังโหลดข้อมูล...
    </div>
</div>
<div class="table-responsive" id="dataTableArea" style="display: none">
    <table class="table table-bordered" id="dataTable" width="100%">
        {{ $slot }}
    </table>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        let table = new DataTable('#dataTable', {
            autoWidth: false,
            orderCellsTop: true,
            fixedHeader: true,
            ordering: {{ $sort }},
            language: {
                url: "{{ asset('plugins/DataTables/th.json') }}",
            },
            buttons: [{
                extend: 'copy',
                title: ''
            }, {
                extend: 'print',
                title: ''
            }],
            dom: '<"row mb-2"<"col"l><"col"f>><"row"<"col"B>>rt<"row"<"col"i><"col"p>>',
            aLengthMenu: [
                [10, 25, 50, 100, 200, -1],
                [10, 25, 50, 100, 200, "ทั้งหมด"]
            ],
            iDisplayLength: 10,
            initComplete: function() {
                $('#loading').slideUp(function() {
                    $('#dataTableArea').slideDown()
                });
            },
        });

    });
</script>
