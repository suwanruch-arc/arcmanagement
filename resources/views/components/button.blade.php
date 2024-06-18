@if ($type === 'a')
    <a href="{{ $href }}" class="btn {{ $class }}" style="{{ $style }}" {{$tooltip}} {{ $onclick }}>
        @if ($icon && $iconPosition === 'prepend')
            <span class="material-symbols-rounded m-auto" style="font-size: {{ $iconSize }};">
                {{ $icon }}
            </span>
        @endif
        {{ $label ?? $slot }}
        @if ($icon && $iconPosition === 'append')
            <span class="material-symbols-rounded m-auto" style="font-size: {{ $iconSize }};">
                {{ $icon }}
            </span>
        @endif
    </a>
@elseif ($type === 'submit')
    <button type="submit" value="{{ $label }}" class="btn {{ $class }}" style="{{ $style }}" {{$tooltip}}>
        @if ($icon && $iconPosition === 'prepend')
            <span class="material-symbols-rounded m-auto" style="font-size: {{ $iconSize }};">
                {{ $icon }}
            </span>
        @endif
        {{ $label ?? $slot }}
        @if ($icon && $iconPosition === 'append')
            <span class="material-symbols-rounded m-auto" style="font-size: {{ $iconSize }};">
                {{ $icon }}
            </span>
        @endif
    </button>
@else
    <button type="{{ $type }}" class="btn {{ $class }}" style="{{ $style }}" {{$tooltip}} {{ $onclick }}>
        @if ($icon && $iconPosition === 'prepend')
            <span class="material-symbols-rounded m-auto" style="font-size: {{ $iconSize }};">
                {{ $icon }}
            </span>
        @endif
        {{ $label ?? $slot }}
        @if ($icon && $iconPosition === 'append')
            <span class="material-symbols-rounded m-auto" style="font-size: {{ $iconSize }};">
                {{ $icon }}
            </span>
        @endif
    </button>
@endif
