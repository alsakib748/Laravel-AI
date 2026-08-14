<?php

use App\Http\Controllers\Api\V1\SetupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    Route::get('/health-check', [SetupController::class, 'healthCheck']);

    Route::get('/verify-ai-sdk', [SetupController::class, 'verifyAiSdk']);

    Route::post('/generate-token', [SetupController::class, 'generateToken']);

});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    Route::get('/me', [SetupController::class, 'me']);

});
