<?php

namespace App\Http\Controllers\Api\V1;

use App\Ai\Agents\SentimentAnalyzer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Http\JsonResponse;

use function Laravel\Ai\{agent};

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


    public function simpleAnonymousAgent()
    {
        $response = agent(
            instructions: 'You are a helpful assistant that speaks like a pirate'
        )->prompt('Tell me about Laravel');

        echo $response;
    }

    public function anonymousStructuredAgent(Request $request): JsonResponse
    {
        $request->validate([
            'text' => 'required|string|max:1000'
        ]);

        $inputText = $request->input('text');

        $response = agent(
            instructions: 'You are a language detection and translation helper.'
            . 'Detect the language of the input text, translate it to English if needed, '
            . 'and estimate how many words are in the text.',
            schema: fn(JsonSchema $schema) => [
                'detected_language' => $schema->string()
                    ->description('The detected language of the input text')
                    ->required(),
                'is_english' => $schema->boolean()
                    ->description('Whether the text is already in English')
                    ->required(),
                'english_translation' => $schema->string()
                    ->description('English translation (same as input if already English)')
                    ->required(),
                'word_count' => $schema->integer()
                    ->min(0)
                    ->description('Approximate word count of the input text')
                    ->required(),
            ]
        )->prompt($inputText);

        return response()->json([
            'chat' => 'Anonymous Agent with Structured Output',
            'input_text' => $inputText,
            'result' => [
                'detected_language' => $response['detected_language'],
                'is_english' => $response['is_english'],
                'english_translation' => $response['english_translation'],
                'word_count' => $response['word_count'],
            ]
        ]);

    }


}
