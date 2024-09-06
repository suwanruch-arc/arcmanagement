<div class="sidebar border border-right col-md-3 col-lg-2 p-0 overflow-auto">
    <div class="offcanvas-md offcanvas-end" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel"
        data-bs-scroll="true">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                        <span class="material-symbols-rounded">
                            dashboard
                        </span>
                        แดชบอร์ด
                    </a>
                </li>
            </ul>
            <x-sidebar-menu :menus="config('menu')" />

            <hr class="my-3" />

            <ul class="nav flex-column mb-3">
                <li class="nav-item">
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button class="nav-link d-flex align-items-center gap-2" type="submit">
                            <span class="material-symbols-rounded">
                                logout
                            </span>
                            ออกจากระบบ
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
