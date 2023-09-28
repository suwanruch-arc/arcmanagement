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
    @yield('content')
    <script type="text/javascript" src="{{ asset('js/dashboard.js') }}"></script>
    @include('includes.script')
    @yield('js')
</body>

</html>
