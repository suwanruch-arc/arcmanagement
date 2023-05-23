<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{env('APP_NAME')}} - Login</title>
    @include('includes.head')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet" />
</head>

<body class="text-center">
    @yield('content')
    @include('includes.script')
</body>

</html>
