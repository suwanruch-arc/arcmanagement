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
<div id="dataTableArea" style="display: none">
    <table class="table table-bordered" id="dataTable" width="100%">
        {{ $slot }}
    </table>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        $('#dataTable thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#dataTable thead');
        let table = new DataTable('#dataTable', {
            orderCellsTop: true,
            fixedHeader: true,
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
                [10, 25, 50, 100, 200, -1],
                [10, 25, 50, 100, 200, "ทั้งหมด"]
            ],
            iDisplayLength: 10,
            initComplete: function() {
                var api = this.api();

                // For each column
                api.columns()
                    .eq(0)
                    .each(function(colIdx) {
                        // Set the header cell to contain the input element
                        var cell = $('.filters th').eq(
                            $(api.column(colIdx).header()).index()
                        );
                        var title = $(cell).text();
                        $(cell).html('<input class="form-control" type="text" />');

                        // On every keypress in this input
                        $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
                            .off('keyup change')
                            .on('change', function(e) {
                                // Get the search value
                                $(this).attr('title', $(this).val());
                                var regexr =
                                    '({search})'; //$(this).parents('th').find('select').val();

                                var cursorPosition = this.selectionStart;
                                // Search the column for that value
                                api
                                    .column(colIdx)
                                    .search(
                                        this.value != '' ?
                                        regexr.replace('{search}', '(((' + this.value +
                                            ')))') :
                                        '',
                                        this.value != '',
                                        this.value == ''
                                    )
                                    .draw();
                            })
                            .on('keyup', function(e) {
                                e.stopPropagation();

                                $(this).trigger('change');
                                $(this)
                                    .focus()[0]
                                    .setSelectionRange(cursorPosition, cursorPosition);
                            });
                    });
                $('#loading').fadeOut(function() {
                    $('#dataTableArea').fadeIn()
                });
            },
        });

    });
</script>
