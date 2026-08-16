<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;

use Laravel\Ai\Files;

use Laravel\Ai\Image;

class ImageGenerationController extends Controller
{

    public function generateImage(Request $request): JsonResponse
    {

        $request->validate([
            'prompt' => 'required|string|max:1000'
        ]);

        $prompt = $request->input('prompt');

        // $image = Image::of($prompt)->generate(provider: 'openai');

        // $image = Image::of($prompt)->generate();

        $image = Image::of($prompt)
            ->landscape()
            ->quality('medium')
            ->generate();

        $path = $image->store('', 'public');

        return response()->json([
            'chat' => 'Basic Image Generation',
            'prompt' => $prompt,
            'path' => $path,
            'url' => asset('storage/' . $path),
        ]);

    }

}
