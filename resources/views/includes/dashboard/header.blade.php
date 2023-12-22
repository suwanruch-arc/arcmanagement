<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-2 shadow-sm">
    <button class="navbar-toggler me-auto m-1 d-md-none collapsed" type="button" data-bs-toggle="collapse"
        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <i class="si-bars"></i>
    </button>
    <a class="text-white text-decoration-none me-auto col-md-3 col-lg-2 me-0 px-3 fs-5" href="/">
        <b class="text-orange">ARC</b>Management
    </a>
    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <form method="POST" action="{{ route('auth.logout') }}">
                @csrf
                <button class="btn nav-link px-3" type="submit">ออกจากระบบ</button>
            </form>
        </div>
    </div>
</header>
