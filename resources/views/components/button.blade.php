<a type="{{ $type }}" href="{{ $href }}" class="btn btn-{{ $color }}">
    @if (empty($slot->toHtml()))
        {{ $text }}
    @else
        {{ $slot }}
    @endif
</a>
