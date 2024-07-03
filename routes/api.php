<?php

use App\Http\Controllers\Managements\PermissionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->name('api.user');

Route::prefix('api')->name('api.')->group(function () {
    Route::controller(PermissionController::class)->prefix('search')->name('search.')->group(function () {
        Route::get('user', 'getUser')->name('get-user');
    });
});