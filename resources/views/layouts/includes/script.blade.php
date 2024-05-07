<script type="text/javascript" src="{{ asset('js/bootstrap-533.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.datetimepicker.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/chart.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/filepond.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/filepond.jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/logger.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/clipboard.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>

<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    $.datetimepicker.setLocale('th');
    $(document).ready(function() {
        $('form#change-status-form').submit(function(e) {
            e.preventDefault();
            const id = $(this).data("id")
            const model = $(this).data("model")
            $.ajax({
                type: "GET",
                url: "{{ route('manage.status.detail') }}",
                data: {
                    id: id,
                    model: model
                },
                dataType: "html",
                success: function(response) {
                    Swal.fire({
                        title: 'คุณแน่ใจใช่ไหม?',
                        html: response,
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
                            var disableId = [];
                            $.each($('[id="disable-id"]'), function(indexInArray,
                                input) {
                                disableId.push({
                                    table: input.name,
                                    id: input.value
                                })
                            });
                            $.ajax({
                                type: "POST",
                                url: "{{ route('manage.status.disable') }}",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    mainId: $('#main_id').val(),
                                    mainTable: $('#main_table').val(),
                                    data: disableId
                                },
                                dataType: "JSON",
                                success: function(response) {
                                    if (response.status === 'ok') {
                                        location.reload()
                                    }
                                }
                            });
                        }
                    })
                }
            });
        });

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
</script>
