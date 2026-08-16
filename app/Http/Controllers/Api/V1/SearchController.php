<?php

namespace App\Http\Controllers\Api\V1;

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

}