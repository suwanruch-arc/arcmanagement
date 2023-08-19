<script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/froala_editor.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/feather.min.js') }}"></script>

<script>
    feather.replace({
        'aria-hidden': 'true'
    })
    $(document).ready(function() {
        $('.select2').select2({
            theme: "bootstrap-5",
            dropdownAutoWidth: 'true'
        });
    });
</script>
