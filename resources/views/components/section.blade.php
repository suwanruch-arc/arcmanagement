<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <p class="h4 d-flex align-items-center gap-2">
            {{ $title }}
        </p>
        <div class="btn-toolbar mb-2 mb-md-0">
            {{ $toolbar }}
        </div>
    </div>
    {{-- <div>
        <div class="d-block d-sm-none">
            Visible only on xs
        </div>
        <div class="d-none d-sm-block d-md-none">
            Visible only on sm
        </div>
        <div class="d-none d-md-block d-lg-none">
            Visible only on md
        </div>
        <div class="d-none d-lg-block d-xl-none">
            Visible only on lg
        </div>
        <div class="d-none d-xl-block d-xxl-none">
            Visible only on xl
        </div>
        <div class="d-none d-xxl-block">
            Visible only on xxl
        </div>
    </div> --}}
    <div>
        {{ $slot }}
    </div>
</div>
