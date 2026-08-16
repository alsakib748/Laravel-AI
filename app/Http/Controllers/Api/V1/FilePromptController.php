<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Ai\Agents\DocumentAnalyzer;

use Laravel\Ai\Files\Document;

use App\Ai\Agents\ImageAnalyzer;

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

    public function analyzeImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:10240',
            'question' => 'required|string|max:500'
        ]);

        $question = $request->input('question');
        $uploadedImage = $request->file('image');

        $response = (new ImageAnalyzer)->prompt(
            $question,
            attachments: [
                $uploadedImage
            ]
        );

        return response()->json([
            'chat' => 'Image Analyzer',
            'filename' => $uploadedImage->getClientOriginalName(),
            'question' => $question,
            'answer' => (string) $response
        ]);

    }

}