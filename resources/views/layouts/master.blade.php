<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ isset($title) ? $title . ' · ' : '' }}ARC Management</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        defer />
    <link href="{{ mix('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ mix('css/sweetalert2.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/filepond.css') }}" rel="stylesheet">
    <link href="{{ asset('css/filepond-plugin-image-preview.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    @yield('style')
</head>

<body>
    <header class="navbar bg-dark flex-md-nowrap p-0 d-flex fixed-top" data-bs-theme="dark">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">
            <b class="text-orange">ARC</b>Management
        </a>
        <div class="me-md-auto order-1 order-md-1">
            @if (isset($prev_route))
                <a class="m-2 text-decoration-none text-white d-flex gap-2 justify-content-center"
                    href="{{ $prev_route }}">
                    <span class="material-symbols-rounded">undo</span> ย้อนกลับ
                </a>
            @endif
        </div>
        <ul class="order-3 navbar-nav flex-row d-md-none">
            <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white d-flex" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="material-symbols-rounded">
                        menu
                    </span>
                </button>
            </li>
        </ul>
    </header>

    <div class="container-fluid h-100 pt-md-5">
        <div class="row h-100">
            @include('layouts.dashboard.sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pb-4">
                <x-breadcrumb :links="$breadcrumb ?? null" />
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ mix('js/sweetalert2.all.min.js') }}"></script>

    <script src="{{ asset('js/filepond.min.js') }}"></script>
    <script src="{{ asset('js/filepond.jquery.js') }}"></script>
    <script src="{{ asset('js/filepond-plugin-image-preview.min.js') }}"></script>
    <script src="{{ asset('js/filepond-plugin-file-validate-size.min.js') }}"></script>
    <script src="{{ asset('js/filepond-plugin-file-validate-type.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    @yield('script')
    <x-toasts />
</body>

</html>
