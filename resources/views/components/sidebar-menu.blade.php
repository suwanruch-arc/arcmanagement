<div>
    <ul class="nav flex-column">
        @foreach ($menus as $menu)
            <li class="nav-item">
                @if (isset($menu['url']))
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ $menu['url'] }}">
                        <span class="material-symbols-rounded">
                            {{ $menu['icon'] ?? 'chevron_right' }}
                        </span>
                        {{ $menu['label'] }}
                    </a>
                @else
                    <small
                        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary">
                        <span>{{ $menu['label'] }}</span>
                    </small>
                @endif
                @if (isset($menu['children']))
                    <x-sidebar-menu :menus="$menu['children']" />
                @endif
            </li>
        @endforeach
    </ul>
</div>
