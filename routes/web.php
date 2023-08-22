<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Managements\DepartmentController;
use App\Http\Controllers\Managements\PartnerController;
use App\Http\Controllers\Managements\ShopController;
use App\Http\Controllers\Site\CampaignController;
use App\Http\Controllers\Site\PrivilegeController;
use App\Http\Controllers\ReportController;

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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::prefix('auth')->name('auth.')->group(function () {
    // Login Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login-form');
    Route::post('login', [LoginController::class, 'login'])->name('login');

    // Logout Route
    Route::post('logout', [LogoutController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::prefix('account')->name('account.')->group(function () { // Change Password Route
        Route::get('change-password', [AccountController::class, 'showChangePasswordForm'])->name('change-password-form');
        Route::post('update-password', [AccountController::class, 'updatePassword'])->name('update-password');
    });

    Route::name('site.')->group(function () {
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('{uuid}', [ReportController::class, 'show'])->name('show');
        });

        Route::prefix('site')->group(function () {

            Route::resource('campaigns', CampaignController::class);
            Route::resource('campaigns.privileges', PrivilegeController::class);
        });
    });

    Route::middleware('admin')->group(function () {
        Route::prefix('manage')->name('manage.')->group(function () {
            Route::prefix('reports')->name('reports.')->group(function () {
                Route::get('get-form', [ReportController::class, 'getForm'])->name('get-form');
                Route::get('get-select-form', [ReportController::class, 'getSelectForm'])->name('get-select-form');
            });
            Route::resource('reports', ReportController::class);
            Route::resource('shops', ShopController::class);
            Route::resource('partners', PartnerController::class);
            Route::resource('partners.departments', DepartmentController::class);
            Route::resource('users', UserController::class);
        });
    });
});
