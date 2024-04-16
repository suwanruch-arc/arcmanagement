<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>ARCManagement</title>
    @include('layouts.includes.head')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" />
    @yield('css')
</head>

<body>
    @include('layouts.includes.dashboard.header')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.includes.dashboard.sidebar')
            <main class="col-12 col-md-9 ms-sm-auto col-lg-10 p-2">
                @yield('content')
            </main>
        </div>
    </div>
    @include('layouts.includes.script')
    @yield('js')
</body>

</html>
