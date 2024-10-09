<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sites\CampaignController;

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
    Route::controller(AuthController::class)->group(function () {
        // Login Routes
        Route::get('login', 'showLoginForm')->name('login-form');
        Route::post('login', 'login')->name('login');
    });

    // Logout Route
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard')->middleware('check.permission:dashboard');

    Route::name('site.')->group(function () {
        Route::middleware('check.permission:campaign')->controller(CampaignController::class)->prefix('campaigns')->name('campaigns.')->group(function () {
            Route::get('pre-create', 'preCreate')->name('pre-create');
        });
        Route::resource('campaigns', CampaignController::class)->middleware('check.permission:campaign');
    });
});