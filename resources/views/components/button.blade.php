<a @if ($tooltip) data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $tooltip }}" @endif
    type="{{ $type }}" href="{{ $href }}"
    class="btn btn-{{ $color }} {{ $class }} d-flex align-item-center gap-1">
    @if ($icon)
        <span class="material-icons-round">
            {{ $icon }}
        </span>
    @endif
    @if (empty($slot->toHtml()))
        {{ $label }}
    @else
        {{ $slot }}
    @endif
</a>
