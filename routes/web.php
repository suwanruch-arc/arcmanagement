<?php

use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Managements\DepartmentController;
use App\Http\Controllers\Managements\PartnerController;
use App\Http\Controllers\Managements\ShopController;
use App\Http\Controllers\Managements\StatusController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Sites\CampaignController;
use App\Http\Controllers\Sites\PrivilegeController;
use App\Http\Controllers\Sites\WarehouseController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\GenerateQrcode;
use App\Http\Livewire\Menus;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(function () {
    // Login Routes
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login-form');
        Route::post('login', 'login')->name('login');
    });

    // Logout Route
    Route::post('logout', [LogoutController::class, 'logout'])->name('logout');
});

Route::get('/qrcode',GenerateQrcode::class);

Route::middleware('auth')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'main')->name('dashboard');
    });

    Route::controller(AccountController::class)->prefix('account')->name('account.')->group(function () { // Change Password Route
        Route::get('change-password', 'showChangePasswordForm')->name('change-password-form');
        Route::post('update-password', 'updatePassword')->name('update-password');
        Route::post('reset-password', 'resetPassword')->name('reset-password');
    });

    Route::name('site.')->group(function () {
        Route::controller(ReportController::class)->prefix('reports')->name('reports.')->group(function () {
            Route::get('{uuid}', 'show')->name('show');
        });

        Route::prefix('site')->group(function () {
            Route::get('/campaigns/pre-create', [CampaignController::class, 'preCreate'])->name('campaigns.pre-create');
            Route::resource('campaigns', CampaignController::class);
            Route::resource('campaigns.privileges', PrivilegeController::class);
            Route::controller(WarehouseController::class)->prefix('/campaigns/{campaign}/warehouse')->name('warehouse.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/import', 'import')->name('import');
                Route::post('/check-format', 'checkFormat')->name('check-format');
                Route::post('/upload', 'upload')->name('upload');
                Route::post('/generate', 'generate')->name('generate');
                Route::delete('/upload', 'delete')->name('delete');
                Route::get('change-privilege', 'changePrivilege')->name('change-privilege');
                Route::post('change-privilege', 'storeChange')->name('save-change');
            });
        });
    });

    Route::middleware('admin')->group(function () {
        Route::prefix('manage')->name('manage.')->group(function () {
            Route::get('/menus', Menus::class)->name('menus');
            Route::controller(StatusController::class)->prefix('status')->name('status.')->group(function () {
                Route::get('detail', 'detail')->name('detail');
                Route::post('disable', 'disable')->name('disable');
                Route::post('reactive', 'reactive')->name('reactive');
            });
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
