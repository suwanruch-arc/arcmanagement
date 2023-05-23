@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<table class="table" id="dataTable" width="100%">
    {{ $slot }}
</table>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let table = new DataTable('#dataTable', {
            responsive: true,
            buttons: [{
                extend: 'copy',
                title: ''
            }, {
                extend: 'print',
                title: ''
            }],
            dom: '<"row mb-2"<"col"l><"col"f>><"row"<"col"B>>rt<"row"<"col"i><"col"p>>',
        });

    });
</script>
