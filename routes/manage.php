<?php

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
Route::middleware('manage')->group(function () {
    Route::get('/dashboard', [ManageController::class, 'dashboard'])->name('manage.dashboard');

    Route::name('manage.')->group(function(){
        //users
        Route::resources([
            'users' => UserController::class
        ]);
    });
});