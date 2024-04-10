<div class="p-2 pt-3">
    <div class="px-2">
        <p class="fs-5"> {{ auth()->user()->name }}</p>
    </div>
    <hr />
    <x-sidebar-menu :menus="config('menu')" />

    <hr class="mb-2" />

    <form method="POST" action="{{ route('auth.logout') }}">
        @csrf
        <ul class="nav flex-column">
            <li class="nav-item">
                <button class="px-3 py-2 nav-link d-flex align-items-center gap-2" type="submit">
                    <span class="material-icons-round fs-6">
                        logout
                    </span>
                    ออกจากระบบ
                </button>
            </li>
        </ul>
    </form>
</div>
