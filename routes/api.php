<?php

declare(strict_types=1);

use App\Http\Controllers\Api\AlternatepaymentController;
use App\Http\Controllers\Api\CopyserviceController;
use App\Http\Controllers\Api\DocusigneventController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\HospitalController;
use App\Http\Controllers\Api\HospitalrawController;
use App\Http\Controllers\Api\PlatformConfigurationController;
use App\Http\Controllers\Api\RoiController;
use App\Http\Controllers\Api\WorkorderController;
use App\Http\Controllers\Api\WorkorderholdtimeController;
use App\Http\Middleware\ApiSessionMiddleware;
use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/docusignevents/webhook', [DocusigneventController::class, 'webhook'])->name('docusignevents.webhook');
Route::get('/docusignevents/webhook', [DocusigneventController::class, 'webhook'])->name('docusignevents.webhook');

Route::group([
    'middleware' => [
        ApiSessionMiddleware::class,
        AuthUser::class,
    ],
], function () {

    Route::get('/workorders/related', [WorkorderController::class, 'related'])->name('workorders.related');

    Route::apiResource('/files', FileController::class);

    Route::apiResource('/hospitals', HospitalController::class);

    Route::apiResource('/hospitalraws', HospitalrawController::class);

    Route::apiResource('/alternatepayments', AlternatepaymentController::class);

    Route::apiResource('/rois', RoiController::class);

    Route::apiResource('/copyservices', CopyserviceController::class);

    Route::apiResource('/workorderholdtimes', WorkorderholdtimeController::class);

    Route::get('/sessiontest', function () {
        return session()->all();
    });

});

Route::group([
    'middleware' => [
        AuthAdmin::class,
    ],
], function () {

    Route::apiResource('/platform-configurations', PlatformConfigurationController::class);

});
