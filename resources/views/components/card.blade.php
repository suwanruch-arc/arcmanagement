<div class="{{ $class }} card {{ $color && !$outline ? 'text-bg-' . $color : 'border-' . $color }}">
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
