<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Managements\DepartmentController;
use App\Http\Controllers\Managements\PartnerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('auth')->name('auth.')->group(function () {
    // Login Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login-form');
    Route::post('login', [LoginController::class, 'login'])->name('login');

    // Logout Route
    Route::post('logout', [LogoutController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('account')->name('account.')->group(function () { // Change Password Route
        Route::get('change-password', [AccountController::class, 'showChangePasswordForm'])->name('change-password-form');
        Route::post('update-password', [AccountController::class, 'updatePassword'])->name('update-password');
    });

    Route::middleware('admin')->prefix('manage')->name('manage.')->group(function () {
        Route::resource('partners', PartnerController::class);
        Route::resource('partners.departments', DepartmentController::class);
        Route::resource('users', UserController::class);
    });
});
