require("./bootstrap");

import * as bootstrap from "bootstrap";

import Swal from "sweetalert2";
window.Swal = Swal;

const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);

$(document).ready(function () {
    $("form.form-destroy").submit(function (e) {
        e.preventDefault();
        Swal.fire({
            icon: "warning",
            title: "การแจ้งเตือน",
            text: "คุณต้องการลบข้อมูลใช่หรือไม่?",
            showCancelButton: true,
            confirmButtonText: "ลบข้อมูล",
            cancelButtonText: "ยกเลิก",
            confirmButtonColor: "#ff4136",
            cancelButtonColor: "#adb5bd",
        }).then((result) => {
            if (result.isConfirmed) {
                e.currentTarget.submit();
            }
        });
    });
    
    $('.select2').select2({
        themes: 'bootstrap-5',
    })

    $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
    $('.file-pond').filepond();
});
