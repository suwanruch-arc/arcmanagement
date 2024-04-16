<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>ARCManagement</title>
    @include('layouts.includes.head')
    @yield('css')
</head>

<body>
    @yield('content')
    @include('layouts.includes.script')
    @yield('js')
</body>

</html>
