<?php

use App\Http\Controllers\Managements\DepartmentController;
use App\Http\Controllers\Managements\PartnerController;
use App\Http\Controllers\Managements\PermissionController;
use App\Http\Controllers\Managements\ShopController;
use App\Http\Controllers\Managements\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManageController;

/*
|--------------------------------------------------------------------------
| Management Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [ManageController::class, 'dashboard'])->name('manage.dashboard');

    Route::name('manage.')->group(function () {
        Route::middleware('check.permission:permission')->controller(PermissionController::class)->prefix('permissions')->name('permissions.')->group(function () {
            Route::get('', 'index')->name('index');
            Route::prefix('users')->name('users.')->group(function () {
                Route::get('/{department}', 'getUsers')->name('get');
                Route::post('/{menu}', 'saveUsers')->name('save');
            });
            Route::get('/{menu}', 'getPermission')->name('get');
        });

        Route::middleware('check.permission:user')->prefix('users')->name('users.')->group(function () {
            Route::post('/restore', [UserController::class, 'restore'])->name('restore');
            Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('reset-password');
        });

        Route::middleware('check.permission:partner')->prefix('partners')->name('partners.')->group(function () {
            Route::post('/restore', [PartnerController::class, 'restore'])->name('restore');
            Route::prefix('departments')->name('departments.')->group(function () {
                Route::post('/restore', [DepartmentController::class, 'restore'])->name('restore');
            });
        });

        Route::resource('users', UserController::class)->middleware('check.permission:user');
        Route::resource('partners', PartnerController::class)->middleware('check.permission:partner');
        Route::resource('partners.departments', DepartmentController::class)->middleware('check.permission:partner');
        Route::resource('shops', ShopController::class)->middleware('check.permission:shop');
    });

    Route::get('/routes', function () {
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'action' => $route->getActionName(),
                'methods' => $route->methods(),
                'middleware' => $route->middleware()
            ];
        });

        return view('routes', compact('routes'));
    })->name('manage.routes.index')->middleware('check.permission:route');
});