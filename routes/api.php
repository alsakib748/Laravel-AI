<?php

use App\Http\Controllers\Api\V1\AgentConfigController;
use App\Http\Controllers\Api\V1\AgentPromptingController;
use App\Http\Controllers\Api\V1\ConversationalAgentController;
use App\Http\Controllers\Api\V1\SetupController;
use App\Http\Controllers\Api\V1\StructuredOutputController;
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

    // todo: Basic Prompt

    Route::get('/basic', [AgentPromptingController::class, 'Basic']);

    Route::post('/prompt', [AgentPromptingController::class, 'promptWithInput']);

    // todo: Remember Conversations Prompt
    Route::post('/conversations/start', [ConversationalAgentController::class, 'startConversation']);

    Route::post('/conversations/continue', [ConversationalAgentController::class, 'continueConversation']);

    // todo: Structured Output
    Route::post('/structured/sentiment', [StructuredOutputController::class, 'analyzeSentiment']);

    // todo: Anonymous Agent
    Route::get('/anonymous/simple', [StructuredOutputController::class, 'simpleAnonymousAgent']);

    Route::post('/anonymous/structured', [StructuredOutputController::class, 'anonymousStructuredAgent']);

    // todo: Customize Agent
    Route::post('/config/creative', [AgentConfigController::class, 'creativeWrite']);
    Route::post('/config/extract', [AgentConfigController::class, 'extractContact']);


});