<header class="navbar sticky-top bg-dark flex-md-nowrap p-0 d-flex" data-bs-theme="dark">
    <a class="order-2 order-md-1 navbar-brand col-md-3 col-lg-2 me-auto me-md-0 px-3 fs-6 text-white"
        href="#">
        <b class="text-orange">ARC</b>Management
    </a>
    <div class="me-md-auto order-1 order-md-1">
        <x-back-btn :route="$route ?? null" />
    </div>
    <ul class="order-3 navbar-nav flex-row d-md-none">
        <li class="nav-item text-nowrap">
            <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="material-icons-round">
                    menu
                </span>
            </button>
        </li>
    </ul>
</header>
