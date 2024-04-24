<?php

use App\Http\Controllers\Managements\Toolcontroller;
use App\Http\Controllers\Sites\EcodeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Managements\DepartmentController;
use App\Http\Controllers\Managements\MapLinkController;
use App\Http\Controllers\Managements\PartnerController;
use App\Http\Controllers\Managements\ShopController;
use App\Http\Controllers\Managements\StatusController;
use App\Http\Controllers\Sites\CampaignController;
use App\Http\Controllers\Sites\PrivilegeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Sites\WarehouseController;

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
    Route::controller(LoginController::class)->group(function () {
        // Login Routes
        Route::get('login', 'showLoginForm')->name('login-form');
        Route::post('login', 'login')->name('login');
    });

    // Logout Route
    Route::post('logout', [LogoutController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'main'])->name('dashboard');

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

            Route::resource('ecode', EcodeController::class)->parameters([
                'ecode' => 'campaign'
            ])->except(['show']);

            Route::controller(EcodeController::class)->prefix('ecode')->name('ecode.')->group(function () {
                Route::prefix('{campaign}')->group(function () {
                    Route::get('dashboard', 'dashboard')->name('dashboard');
                    Route::get('import', 'import')->name('import');
                });
                Route::post('load', 'load')->name('load');
                Route::get('check', 'check')->name('check');
                Route::post('generate', 'generate')->name('generate');
                Route::get('export', 'export')->name('export');
                Route::post('remove', 'remove')->name('remove');
            });
        });
    });

    Route::middleware('admin')->group(function () {
        Route::prefix('manage')->name('manage.')->group(function () {
            Route::controller(Toolcontroller::class)->prefix('tools')->name('tools.')->group(function () {
                Route::get('dashboard', 'dashboard')->name('dashboard');
                Route::get('upload', 'upload')->name('upload');
                Route::post('process', 'process')->name('process');
                // Route::get('check', 'check')->name('check');
                // Route::post('generate', 'generate')->name('generate');
                // Route::get('export', 'export')->name('export');
                // Route::delete('load', 'delete');
            });
            Route::controller(StatusController::class)->prefix('status')->name('status.')->group(function () {
                Route::get('detail', 'detail')->name('detail');
                Route::post('disable', 'disable')->name('disable');
                Route::post('reactive', 'reactive')->name('reactive');
            });
            Route::controller(ReportController::class)->prefix('reports')->name('reports.')->group(function () {
                Route::get('get-form', 'getForm')->name('get-form');
                Route::get('get-select-form', 'getSelectForm')->name('get-select-form');
            });
            Route::resource('reports', ReportController::class);
            Route::resource('shops', ShopController::class);
            Route::resource('partners', PartnerController::class);
            Route::resource('partners.departments', DepartmentController::class);
            Route::resource('users', UserController::class);
        });
    });
});
