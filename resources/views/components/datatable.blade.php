@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<table class="table table-bordered" id="dataTable" width="100%">
    {{ $slot }}
</table>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let table = new DataTable('#dataTable', {
            ordering: {{ $sort }},
            responsive: true,
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
                [10,25, 50, 100, 200, -1],
                [10,25, 50, 100, 200, "ทั้งหมด"]
            ],
            iDisplayLength: 10
        });

    });
</script>
