<{{$isButton ? 'button' : 'a'}} class="{{ $class }}" {{ $tooltip }} type="{{ $type }}" href="{{ $href }}">
    @if ($icon)
        <span class="material-icons-round {{ $size === 'sm' ? 'fs-5' : '' }} {{ $size === 'lg' ? 'fs-3' : '' }}">
            {{ $icon }}
        </span>
    @endif
    @if (empty($slot->toHtml()))
        {{ $label }}
    @else
        {{ $slot }}
    @endif
    @if ($prependIcon)
        <span class="material-icons-round {{ $size === 'sm' ? 'fs-5' : '' }} {{ $size === 'lg' ? 'fs-3' : '' }}">
            {{ $prependIcon }}
        </span>
    @endif
</{{$isButton ? 'button' : 'a'}}>