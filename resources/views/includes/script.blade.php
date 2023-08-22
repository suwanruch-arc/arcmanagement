<script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/froala_editor.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/feather.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.datetimepicker.full.min.js') }}"></script>

<script>
    feather.replace({
        'aria-hidden': 'true'
    })
    $(document).ready(function() {
        $('.select2').select2({
            theme: "bootstrap-5",
            dropdownAutoWidth: 'true'
        });

        $('.numberonly').keypress(function(e) {

            var charCode = (e.which) ? e.which : event.keyCode

            if (String.fromCharCode(charCode).match(/[^0-9]/g))

                return false;

        });
    });

    function showTandC(html) {
        Swal.fire({
            html: html,
            showConfirmButton: false,
        })
    }

    var editor = new FroalaEditor('.editor', {
        heightMin: 200,
        toolbarInline: false,
        quickInsertEnabled: false,
        toolbarButtons: [
            [
                'bold', 'italic', 'underline', 'superscript', 'formatOL',
                'formatUL',
                'clearFormatting', 'fontSize', 'textColor', 'backgroundColor', 'html'
            ],
        ]
    });
</script>
