@extends('layouts.auth', ['title' => 'Signin'])

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
            <input type="text" class="form-control" id="username_or_email" name="username_or_email"
                placeholder="อีเมล / ชื่อผู้ใช้งาน" required value="{{old('username_or_email')}}">
            <label for="username_or_email">ชื่อผู้ใช้งาน</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required
                value="{{old('password')}}">
            <label for="password">รหัสผ่าน</label>
        </div>

        <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" value="remember" id="remember" name="remember" checked>
            <label class="form-check-label" for="remember">
                จดจำการเข้าสู่ระบบ
            </label>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit">เข้าสู่ระบบ</button>
    </form>
</main>
@endsection

@section('script')

@endsection