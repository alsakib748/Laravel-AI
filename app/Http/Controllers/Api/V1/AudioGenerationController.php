<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Laravel\Ai\Audio;
use ILLuminate\Http\JsonResponse;

class AudioGenerationController extends Controller
{

    public function generateAudio(Request $request): JsonResponse
    {

        $request->validate([
            'text' => 'required|string|max:5000',
        ]);

        $textInput = $request->input('text');

        // $audio = Audio::of($textInput)
        //     ->male()
        //     ->generate();

        $audio = Audio::of($textInput)
            ->instructions("Say it like a Pirate")
            ->generate();

        $path = $audio->store('audio', 'public');

        return response()->json([
            'chat' => 'Basic Text-to-Speech',
            'text' => $textInput,
            'path' => $path,
            'url' => asset('storage/' . $path),
        ]);

    }

}
