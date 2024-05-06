<a class="{{ $class }}" {{ $tooltip }} type="{{ $type }}" href="{{ $href }}">
    @if ($icon)
        <span class="material-icons-round fs-5">
            {{ $icon }}
        </span>
    @endif
    @if (empty($slot->toHtml()))
        {{ $label }}
    @else
        {{ $slot }}
    @endif
</a>