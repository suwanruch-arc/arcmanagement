@extends('layouts.auth')

@section('content')
    <main class="form-signin w-100 m-auto">
        <form action="{{ route('auth.login') }}" method="POST">
            @csrf
            <h4>
                <b class="text-orange">ARC</b>Management
            </h4>

            <hr />

            <div class="form-floating">
                <input type="text" class="form-control" id="username" name="username" placeholder="username"
                    autocomplete="off">
                <label for="username">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                    autocomplete="off">
                <label for="password">Password</label>
            </div>

            <div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" value="yes" id="remember" name="remember" checked>
                <label class="form-check-label" for="remember">
                    Remember me
                </label>
            </div>

            <hr />

            <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
        </form>
    </main>
@endsection
