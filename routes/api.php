<?php

use App\Http\Controllers\Api\DetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\RedeemController;

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

Route::controller(DetailController::class)->group(function () {
    Route::get('detail', 'getData');
});

Route::controller(RedeemController::class)->group(function () {
    Route::post('get-code', 'getCode');
    Route::post('view-code', 'getView');
});

Route::prefix('img')->controller(ImageController::class)->group(function () {
    Route::get('logo', 'getLogoPartner');
    Route::get('{partner}', 'getPartner');
});
