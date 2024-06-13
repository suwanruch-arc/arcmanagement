<?php

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
    Route::get('/settings', [ManageController::class, 'settings'])->name('manage.settings');
    // เพิ่มเส้นทางอื่นๆ ของ ManageController ที่นี่
});