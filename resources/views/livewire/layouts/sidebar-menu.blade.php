    <li class="nav-item">
        <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="#">
            <span class="material-icons-round">
                {{ $menu['icon '] ?? 'circle' }}
            </span>
            {{ $menu['name'] }}
        </a>
        @if (isset($menu['children']))
            <ul class="nav flex-column">
                @foreach ($menu['children'] as $children)
                    @livewire('layouts.sidebar-menu', ['children' => $children])
                @endforeach
            </ul>
        @endif
    </li>
