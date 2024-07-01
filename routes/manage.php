<?php

use App\Http\Controllers\Managements\DepartmentController;
use App\Http\Controllers\Managements\PartnerController;
use App\Http\Controllers\Managements\PermissionController;
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
Route::middleware(['manage', 'auth'])->group(function () {
    Route::get('/dashboard', [ManageController::class, 'dashboard'])->name('manage.dashboard');

    Route::name('manage.')->group(function () {
        Route::prefix('menus')->name('menus')->group(function () {
            Route::get('', [PermissionController::class, 'index'])->name('index');
        });

        Route::prefix('users')->name('users.')->group(function () {
            Route::post('/restore', [UserController::class, 'restore'])->name('restore');
            Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('reset-password');
        });

        Route::prefix('partners')->name('partners.')->group(function () {
            Route::post('/restore', [PartnerController::class, 'restore'])->name('restore');
            Route::prefix('departments')->name('departments.')->group(function () {
                Route::post('/restore', [DepartmentController::class, 'restore'])->name('restore');
            });
        });

        Route::resources([
            'users' => UserController::class,
            'partners' => PartnerController::class,
            'partners.departments' => DepartmentController::class
        ]);
    });

    Route::get('/routes', function () {
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'action' => $route->getActionName(),
                'methods' => $route->methods(),
            ];
        });

        return view('routes', compact('routes'));
    })->name('manage.routes.index');
});