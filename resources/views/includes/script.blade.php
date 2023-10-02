<script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/froala_editor.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/feather.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.datetimepicker.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/filepond.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/filepond.jquery.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script>
    feather.replace({
        'aria-hidden': 'true'
    })
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    $(document).ready(function() {
        $('.uppercase').keyup(function(e) {
            const value = this.value.toUpperCase()
            $(this).val(value);
        });
        $('.select2').select2({
            theme: "bootstrap-5",
            dropdownAutoWidth: 'true'
        });

        $('.numberonly').keypress(function(e) {

            var charCode = (e.which) ? e.which : event.keyCode

            if (String.fromCharCode(charCode).match(/[^0-9]/g))

                return false;

        });

        $('.editor').summernote({

            height: 250
        });
    });

    function showTandC(html) {
        Swal.fire({
            html: html,
            showConfirmButton: false,
        })
    }

    // var editor = new FroalaEditor('.editor', {
    //     heightMin: 200,
    //     toolbarInline: false,
    //     quickInsertEnabled: false,
    //     toolbarButtons: [
    //         [
    //             'bold', 'italic', 'underline', 'superscript', 'formatOL',
    //             'formatUL',
    //             'clearFormatting', 'fontSize', 'textColor', 'backgroundColor', 'html'
    //         ],
    //     ]
    // });
</script>
