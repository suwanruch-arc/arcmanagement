<a type="{{ $type }}" href="{{ $href }}" class="btn btn-{{ $color }} {{ $class }}"
    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $label }}">
    @if (empty($slot->toHtml()))
        {{ $text }}
    @else
        {{ $slot }}
    @endif
</a>
