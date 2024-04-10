<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ARCManagement</title>
    @livewireStyles
    @include('layouts.includes.head')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
</head>
@yield('css')

<body>
    <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 d-flex" data-bs-theme="dark">
        <a class="order-2 order-md-1 navbar-brand col-md-3 col-lg-2 me-auto me-md-0 px-3 fs-6 text-white"
            href="#">
            <b class="text-orange">ARC</b>Management
        </a>
        <div class="me-md-auto order-1  order-md-1">
            <x-back-btn :route="$route ?? null" />
        </div>
        <ul class="order-3 navbar-nav flex-row d-md-none">
            <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="material-icons-round">
                        menu
                    </span>
                </button>
            </li>
        </ul>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="sidebar col-md-3 col-lg-2 p-0 ">
                <div class="offcanvas-md offcanvas-end m-md-2 border bg-body-tertiary" tabindex="-1" id="sidebarMenu"
                    aria-labelledby="sidebarMenuLabel">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            data-bs-target="#sidebarMenu" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-md-flex flex-column p-0 overflow-y-auto">
                        <x-sidebar />
                    </div>
                </div>
            </div>

            <main class="col-md-9 ms-sm-auto col-lg-10 p-2">
                @yield('content')
            </main>
        </div>
    </div>
    @livewireScripts
    @include('layouts.includes.script')
    @yield('js')

    @if (session()->has('success'))
        <script>
            toastr.success("{!! session('success') !!}")
        </script>
    @endif
    @if (session()->has('message'))
        <script>
            toastr.info("{!! session('message') !!}")
        </script>
    @endif
    @if (session()->has('error'))
        <script>
            toastr.error("{!! session('error') !!}")
        </script>
    @endif
</body>

</html>
