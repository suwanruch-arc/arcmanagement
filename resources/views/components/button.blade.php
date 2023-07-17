<a type="{{ $type }}" href="{{ $href }}" class="btn btn-{{ $color }} {{ $class }}">
    @if (empty($slot->toHtml()))
        {{ $text }}
    @else
        {{ $slot }}
    @endif
</a>
