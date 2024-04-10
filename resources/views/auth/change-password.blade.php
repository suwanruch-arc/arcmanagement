@extends('layouts.app', ['route' => route('dashboard')])

@section('head_title')
    Change Password
@endsection

@section('content')
    <x-container cols=6>
        <x-card>
            <x-card-header>
                <div class="fs-5">
                    เปลี่ยนรหัสผ่าน
                </div>
            </x-card-header>
            <x-card-body>
                <x-form method="POST" action="{{ route('account.update-password') }}">
                    <div class="row row-cols-1 row-cols-md-2">
                        <div class="col">
                            <x-input required type="password" name="password" id="password" label="รหัสผ่าน"
                                placeholder="กรุณากรอกรหัสผ่าน" min="6" max="20" />
                        </div>
                        <div class="col">
                            <x-input required type="password" name="confirm_password" id="confirm_password"
                                label="ยืนยันรหัสผ่าน" placeholder="กรุณายืนยันรหัสผ่าน" min="6" max="20" />
                        </div>
                    </div>
                </x-form>
            </x-card-body>
        </x-card>
    </x-container>
@endsection

@section('js')
    <script>
        $('form').submit(function(e) {
            var password = $('#password').val();
            var confirmPassword = $('#confirm_password').val();

            if (password !== confirmPassword) {
                e.preventDefault();
                alert("Password and Confirm Password do not match.");
            }
        })
    </script>
@endsection
