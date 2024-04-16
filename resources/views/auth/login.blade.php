@extends('layouts.auth')

@section('content')
    <main class="form-signin w-100 m-auto">
        <form action="{{ route('auth.login') }}" method="POST">
            @csrf
            <h4>
                <b class="text-orange">ARC</b>Management
            </h4>

            <hr />

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <small>{{ $errors->first() }}</small>
                </div>
            @endif
            <div class="form-floating">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                    value="{{ old('username') }}">
                <label for="username">ชื่อผู้ใช้งาน</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <label for="password">รหัสผ่าน</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" id="rememberme" name="rememberme" checked> จดจำการเข้าสู่ระบบ
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">
                <i class="material-icons-round">login</i>
                เข้าสู่ระบบ
            </button>
        </form>
    </main>
@endsection
