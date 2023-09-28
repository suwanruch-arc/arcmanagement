<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Login</title>
    @include('includes.head')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet" />
</head>

<body class="text-center">
    @yield('content')
    @include('includes.script')
</body>

</html>
