<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Ai\Agents\DocumentAnalyzer;

use Laravel\Ai\Files\Document;

use Illuminate\Http\JsonResponse;

class FilePromptController extends Controller
{

    public function analyzeDocument(Request $request): JsonResponse
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'document' => 'required|file|mimes:pdf,txt,md,csv,json,docx,xlsx'
        ]);

        $question = $request->input('question');

        $document = $request->file('document');

        $response = (new DocumentAnalyzer)->prompt(
            $question,
            attachments: [
                // $document,
                Document::fromStorage("bug-tracker.md")
            ]
        );

        return response()->json([
            'chat' => 'Document Analyzer',
            'filename' => $document->getClientOriginalName(),
            'question' => $question,
            'answer' => (string) $response,
        ]);

    }

}
