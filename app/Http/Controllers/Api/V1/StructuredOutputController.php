<?php

namespace App\Http\Controllers\Api\V1;

use App\Ai\Agents\SentimentAnalyzer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Http\JsonResponse;

class StructuredOutputController extends Controller
{

    public function analyzeSentiment(Request $request): JsonResponse
    {
        $request->validate([
            'text' => 'required|string|max:2000'
        ]);

        $response = (new SentimentAnalyzer())
            ->prompt($request->input('text'));

        // Structured Agent Response [ArrayAccess]

        return response()->json([
            'chat' => 'Sentiment Analysis (Structured Output)',
            'input_text' => $request->input('text'),
            'analysis' => [
                'sentiment' => $response['sentiment'],
                'score' => $response['score'],
                'topics' => $response['topics'],
                'summary' => $response['summary'],
            ]
        ]);

    }

}