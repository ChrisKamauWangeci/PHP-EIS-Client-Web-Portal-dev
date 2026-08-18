<?php

declare(strict_types=1);

use App\Http\Middleware\ApiSessionMiddleware;
use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/docusignevents/webhook', [App\Http\Controllers\Api\DocusigneventController::class, 'webhook'])->name('docusignevents.webhook');
Route::get('/docusignevents/webhook', [App\Http\Controllers\Api\DocusigneventController::class, 'webhook'])->name('docusignevents.webhook');

Route::group([
    'middleware' => [
        ApiSessionMiddleware::class,
        AuthUser::class,
    ],
], function () {

    Route::get('/workorders/related', [App\Http\Controllers\Api\WorkorderController::class, 'related'])->name('workorders.related');

    Route::apiResource('/files', App\Http\Controllers\Api\FileController::class);

    Route::apiResource('/hospitals', App\Http\Controllers\Api\HospitalController::class);

    Route::apiResource('/hospitalraws', App\Http\Controllers\Api\HospitalrawController::class);

    Route::apiResource('/alternatepayments', App\Http\Controllers\Api\AlternatepaymentController::class);

    Route::apiResource('/rois', App\Http\Controllers\Api\RoiController::class);

    Route::apiResource('/copyservices', App\Http\Controllers\Api\CopyserviceController::class);

    Route::apiResource('/workorderholdtimes', App\Http\Controllers\Api\WorkorderholdtimeController::class);

    Route::get('/sessiontest', function () {
        return session()->all();
    });

});

Route::group([
    'middleware' => [
        AuthAdmin::class,
    ],
], function () {

    Route::apiResource('/platform-configurations', App\Http\Controllers\Api\PlatformConfigurationController::class);

});
