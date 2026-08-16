<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Ai\Agents\TimeAwareAssistant;

use function Laravel\Ai\{agent};

class ToolUsageController extends Controller
{
    public function getRequestedTime(Request $request): JsonResponse
    {
        $request->validate([
            'question' => 'required|string|max: 500'
        ]);

        $question = $request->input('question');

        $withoutTools = agent(
            instructions: 'You are a helpful assistant. Answer the question directly'
        )->prompt($question);

        $response = (new TimeAwareAssistant)->prompt($question);

        return response()->json([
            'chat' => 'Time-Aware Assistant',
            'question' => $question,
            'answer' => (string) $response,
            'without_tools' => $withoutTools,
        ]);

    }
}