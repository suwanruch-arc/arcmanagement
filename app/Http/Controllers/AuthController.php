<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $fieldType = filter_var($request->input('username_or_email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $request->username_or_email,
            'password' => $request->password,
        ];
        $remember = $request->has('remember');
        if (Auth::attempt($credentials, $remember)) {
            return redirect()->intended('dashboard');
        }

        return back()->withInput()->withErrors('การเข้าสู่ระบบล้มเหลว โปรดลองอีกครั้ง');
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }
}
