<?php

namespace App\Http\Controllers\Api\V1;

use App\Ai\Agents\PageAnalyzer;
use App\Ai\Agents\WebResearcher;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function research(Request $request): JsonResponse
    {
        $request->validate([
            'question' => 'required|string|max:1000'
        ]);

        $question = $request->input('question');

        $response = (new WebResearcher)->prompt($question);

        return response()->json([
            'chat' => 'Web Researcher (General Search)',
            'question' => $question,
            'answer' => (string) $response,
        ]);

    }

    public function analyzePage(Request $request): JsonResponse
    {

        $request->validate([
            'prompt' => 'required|string|max:1000'
        ]);

        $prompt = $request->input('prompt');

        $response = (new PageAnalyzer)->prompt($prompt);

        return response()->json([
            'chat' => 'Page Analyzer (WebFetch)',
            'prompt' => $prompt,
            'answer' => (string) $response,
        ]);

    }

}
