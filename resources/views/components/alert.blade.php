<div class="alert alert-{{ $type }}{{ $dismiss ? ' alert-dismissible' : '' }}" role="alert">
    @if ($dismiss)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
    {{ $slot }}
</div>
