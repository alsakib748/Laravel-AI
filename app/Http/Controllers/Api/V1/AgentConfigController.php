<?php

namespace App\Http\Controllers\Api\V1;

use App\Ai\Agents\CreativeWriter;
use App\Ai\Agents\PreciseExtractor;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgentConfigController extends Controller
{

    public function creativeWrite(Request $request): JsonResponse
    {
        $request->validate([
            'prompt' => 'required|string|max:500',
            'genre' => 'required|string|max:50'
        ]);

        $genre = $request->input('genre', 'general');
        $prompt = "Genre: {$genre}\n\n" . $request->input('prompt');

        $response = (new CreativeWriter)->prompt($prompt);

        return response()->json([
            'chat' => 'Creative Writer (Hight Temperature)',
            'genre' => $genre,
            'result' => (string) $response,
        ]);

    }

    public function extractContact(Request $request): JsonResponse
    {
        $request->validate([
            'text' => 'required|string|max:2000'
        ]);

        $textInput = $request->input('text');

        $response = (new PreciseExtractor)->prompt(
            'Extract contact information from this text: ' . $textInput
        );

        return response()->json([
            'chat' => 'Precise Extractor (Low Temperature)',
            'result' => [
                'name' => $response['name'],
                'email' => $response['email'],
                'phone' => $response['phone'],
                'company' => $response['company'],
            ]
        ]);

    }

}
