@extends('layouts.master')

@section('head_title')
    Change Password
@endsection

@section('content')
    <x-container cols="6">
        <x-card>
            <x-form method="POST" action="{{ route('account.update-password') }}">
                <div class="row row-cols-1 row-cols-md-2">
                    <div class="col">
                        <x-input required type="password" name="password" id="password" label="Password"
                            placeholder="กรุณากรอกรหัสผ่าน" min="6" max="20" />
                    </div>
                    <div class="col">
                        <x-input required type="password" name="confirm_password" id="confirm_password"
                            label="Confirm Password" placeholder="ยืนยันกรอกรหัสผ่าน" min="6" max="20" />
                    </div>
                </div>
            </x-form>
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
