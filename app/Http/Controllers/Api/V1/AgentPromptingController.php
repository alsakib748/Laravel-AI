<?php

namespace App\Http\Controllers\Api\V1;

use App\Ai\Agents\BasicAgent;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgentPromptingController extends Controller
{
    public function Basic(): JsonResponse
    {
        $agent = BasicAgent::make();

        $response = $agent->prompt('Hello! What are you and what can you help me with?');

        return response()->json([
            'basic' => 'Basic Prompt',
            'response' => (string) $response,
        ]);

    }

    public function promptWithInput(Request $request): JsonResponse
    {

        $request->validate([
            'prompt' => 'required|string|max:1000'
        ]);

        // $agent = BasicAgent::make();

        $prompt = $request->input('prompt');

        $response = (new BasicAgent)->prompt($prompt);

        return response()->json([
            'prompt' => 'Prompt with user input',
            'message' => (string) $prompt,
            'response' => (string) $response,
        ]);

    }

}