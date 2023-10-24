<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>ARCManagement</title>
    @include('includes.head')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" />
    @yield('css')
</head>

<body>
    @include('includes.dashboard.header')
    <div class="container-fluid">
        <div class="row">
            @include('includes.dashboard.sidebar')
            <main id="mainSection" class="col-md-9 ms-sm-auto col-lg-10 px-3 py-4">
                <x-back-btn :route="$route ?? null" />
                @yield('title')
                <section class="pt-3">
                    @yield('content')
                </section>
            </main>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/dashboard.js') }}"></script>
    @include('includes.script')
    @yield('js')
</body>

</html>
