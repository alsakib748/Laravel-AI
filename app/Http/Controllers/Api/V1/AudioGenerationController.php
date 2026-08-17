<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Laravel\Ai\Audio;
use ILLuminate\Http\JsonResponse;
use Laravel\Ai\Transcription;

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

    public function transcribeAudio(Request $request): JsonResponse
    {

        $request->validate([
            'audio' => 'required|file|mimes:mp3,mp4,wav,m4a,webm|max:25600',
        ]);

        $audioToTranscribe = $request->file('audio');

        $transcript = Transcription::fromUpload(
            $audioToTranscribe
        )->generate();

        return response()->json([
            'chat' => 'Basic Transcription',
            'filename' => $audioToTranscribe->getClientOriginalName(),
            'text' => (string) $transcript,
        ]);

    }

}
