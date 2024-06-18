require("./bootstrap");

window.$ = window.jQuery = require("jquery");

import * as bootstrap from "bootstrap";

import Swal from 'sweetalert2'
window.Swal = Swal;

const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);