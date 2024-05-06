<div>
    <table class="table table-bordered" id="dt">
        {!! $slot !!}
    </table>
</div>
@section('js')
    @parent
    <script>
        new DataTable('#dt', {
            dom: 't',
            iDisplayLength: 25,
            ordering: false,
        })
    </script>
@endsection