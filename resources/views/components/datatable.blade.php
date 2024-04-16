@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {!! $message !!}
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
    <table class="table table-bordered nowrap" id="dataTable" width="100%">
        {{ $slot }}
    </table>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        var table = new DataTable('#dataTable', {
            autoWidth: false,
            orderCellsTop: true,
            fixedHeader: true,
            responsive: true,
            order: [],
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
            dom: '<"row mb-2"<"col d-flex gap-2"Bl><"col"f>>rt<"row"<"col"i><"col"p>>',
            aLengthMenu: [
                [ 25, 50, 100, 200, -1],
                [ 25, 50, 100, 200, "ทั้งหมด"]
            ],
            iDisplayLength: 25,
            initComplete: function() {
                $('#loading').slideUp(200, function() {
                    $('#dataTableArea').slideDown(200)
                });
            },
        });

    });
</script>
