<a type="{{ $type }}" href="{{ $href }}" class="btn btn-{{ $color }}">
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @else
        {{ $text }}
    @endif
</a>
