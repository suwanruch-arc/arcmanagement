{{-- <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark bg-opacity-10 sidebar collapse border-end"> --}}
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark bg-opacity-10 sidebar collapse border-end">
    <div class="position-sticky sidebar-sticky">
        <ul class="nav flex-column">
            <h5 class="d-flex align-items-center px-3 mt-4">
                <span>{{ Auth::user()->name }}</span>
            </h5>
            <hr class="mx-2">
            @foreach (config('menu') as $menu_header => $item)
                @if (!empty($item))
                    @can($menu_header)
                        <h6
                            class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-capitalize">
                            <span>{{ $menu_header }}</span>
                        </h6>
                        @foreach ($item as $menu)
                            <li class="nav-item">
                                <a class="align-middle nav-link @if (isset($menu['url']) && (Request::is($menu['url']) || str_contains(Request::getRequestUri(), $menu['url']))) active @endif"
                                    href="{{ '/' . $menu['url'] ?? '#' }}">
                                    <span data-feather="{{ $menu['icon'] ?? 'box' }}"></span>
                                    {{ $menu['text'] }}
                                </a>
                            </li>
                        @endforeach
                    @endcan
                @endif
            @endforeach
        </ul>
    </div>
</nav>
