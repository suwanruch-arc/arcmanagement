<div>
    <ul class="nav flex-column pb-2">
        @foreach ($menus as $menu)
            @livewire('layouts.sidebar-menu', ['menu' => $menu])
        @endforeach
    </ul>

    {{-- <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="#">
                <svg class="bi">
                    <use xlink:href="#house-fill" />
                </svg>
                Dashboard
            </a>
        </li>
    </ul>

    <h6
        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
        <span>Saved reports</span>
    </h6>
    <ul class="nav flex-column mb-auto">
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="#">
                <svg class="bi">
                    <use xlink:href="#file-earmark-text" />
                </svg>
                Current month
            </a>
        </li>
    </ul>

    <hr class="my-3" />

    <ul class="nav flex-column mb-auto">
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="#">
                <svg class="bi">
                    <use xlink:href="#gear-wide-connected" />
                </svg>
                Settings
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="#">
                <svg class="bi">
                    <use xlink:href="#door-closed" />
                </svg>
                Sign out
            </a>
        </li>
    </ul> --}}
</div>
