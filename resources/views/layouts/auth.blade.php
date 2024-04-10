<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ARCManagement</title>
    @livewireStyles
    @include('layouts.includes.head')
    <link rel="stylesheet" href="{{ asset('css/sign-in.css') }}" />
</head>
@yield('css')

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    @yield('content')

    @livewireScripts
    @include('layouts.includes.script')
    @yield('js')
</body>

</html>
