<div class="{{ $fluid ? 'container-fluid' : 'container' }} {{ $class }}">
    @if ($cols)
        <div class="row justify-content-center">
            <div
                class="col-{{ $cols }} {{ $sm ? " col-sm-$sm" : '' }}{{ $md ? " col-md-$md" : '' }}{{ $lg ? " col-lg-$lg" : '' }}">
                {{ $slot }}
            </div>
        </div>
    @else
        {{ $slot }}
    @endif
</div>
