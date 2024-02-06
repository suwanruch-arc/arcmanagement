@extends('layouts.auth')

@section('content')
    <main class="form-signin w-100 m-auto">
        <form action="{{ route('auth.login') }}" method="POST">
            @csrf
            <img src="{{ asset('arcinnovative.svg') }}" alt="" width="50%" height="50%">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <small>{{ $errors->first() }}</small>
                </div>
            @endif
            <div class="form-floating">
                <input type="text" class="form-control" id="username"
                    name="username" placeholder="Username" value="{{ old('username') }}">
                <label for="username">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" >
                <label for="password">Password</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" id="rememberme" name="rememberme" checked> Remember me
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit"><i class="material-icons-round">login</i> Sign in</button>
            <p class="mt-5 mb-3 text-muted">&copy; {{date('Y')}}</p>
        </form>
    </main>
@endsection
