<ul class="nav flex-column">
    @foreach ($menus as $menu)
        @if (!isset($menu['can']) || in_array(auth()->user()->role, $menu['can']))
            <li class="nav-item">
                @if (isset($menu['url']))
                    <a class="px-3 py-2 nav-link d-flex align-items-center gap-2" href="{{ $menu['url'] }}">
                        <span class="material-icons-round fs-6">
                            {{ $menu['icon'] ?? 'chevron_right' }}
                        </span>
                        {{ $menu['label'] }}
                    </a>
                @else
                    <small class="p-1 sidebar-heading d-flex text-body-secondary">
                        <span>{{ $menu['label'] }}</span>
                    </small>
                @endif
                @if (isset($menu['children']))
                    <x-sidebar-menu :menus="$menu['children']" />
                @endif
            </li>
        @endif
    @endforeach
</ul>
