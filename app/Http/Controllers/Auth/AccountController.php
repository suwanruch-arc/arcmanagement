<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\ReportServiceProvider;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|min:6|max:20|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        $user = User::find(Auth::id());
        $user->password = Hash::make($request->confirm_password);
        $user->save();

        return redirect()->route('dashboard')->with('success', 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว!');
    }

    public function resetPassword(Request $request)
    {
        $id = $request->id;
        return User::find($id)->update(['password' => Hash::make('Pass@1234')]);
    }
}
