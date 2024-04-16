<div class="{{ $class }} card {{ $color && !$outline ? 'text-bg-' . $color : 'border-' . $color }}">
    {{ $slot }}
</div>
