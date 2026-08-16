<?php

use App\Http\Controllers\Api\V1\AgentConfigController;
use App\Http\Controllers\Api\V1\AgentPromptingController;
use App\Http\Controllers\Api\V1\ConversationalAgentController;
use App\Http\Controllers\Api\V1\FilePromptController;
use App\Http\Controllers\Api\V1\ImageGenerationController;
use App\Http\Controllers\Api\V1\SearchController;
use App\Http\Controllers\Api\V1\SetupController;
use App\Http\Controllers\Api\V1\StructuredOutputController;
use App\Http\Controllers\Api\V1\ToolUsageController;
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

    // todo: Using Tool in an agent
    Route::post('/tools/time-assistant', [ToolUsageController::class, 'getRequestedTime']);

    // todo: Web Search
    Route::post('/web/research', [SearchController::class, 'research']);

    Route::post('/fetch/analyze', [SearchController::class, 'analyzePage']);

    // todo: Files
    Route::post('/files/analyze-document', [FilePromptController::class, 'analyzeDocument']);

    // todo: Image
    Route::post('/files/analyze-image', [FilePromptController::class, 'analyzeImage']);

    // todo: Image Generation
    Route::post('/images/generate', [ImageGenerationController::class, 'generateImage']);

});