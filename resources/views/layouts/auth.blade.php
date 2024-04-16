<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Login</title>
    @include('layouts.includes.head')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet" />
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    @yield('content')
    @include('layouts.includes.script')
</body>

</html>
