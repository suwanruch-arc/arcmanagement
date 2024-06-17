<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{(isset($title) ? $title . ' · ' : '')}}ARC Management</title>
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
    @yield('style')
</head>

<body>
    <header class="navbar sticky-top bg-dark flex-md-nowrap p-0" data-bs-theme="dark">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">Company name</a>

        <ul class="navbar-nav flex-row d-md-none">
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

        <div id="navbarSearch" class="navbar-search w-100 collapse">
            <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search" />
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            @include('layouts.dashboard.sidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pb-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    @yield('script')
</body>

</html>