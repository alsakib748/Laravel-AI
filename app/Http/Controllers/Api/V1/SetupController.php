<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class SetupController extends Controller
{

    public function healthCheck(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'message' => 'Laravel AI Course API is running!',
            'laravel_version' => app()->version(),
        ]);
    }

    public function verifyAiSdk(): JsonResponse
    {

        // Check 1: Is the AI config file loaded?
        $aiConfigLoaded = !is_null(config('ai'));

        // Check 2: Do the AI SDK database tables exist?
        $conversationsTableExists = Schema::hasTable('agent_conversations');
        $messagesTableExists = Schema::hasTable('agent_conversation_messages');

        // Check 3: Are any provider API keys configured?
        $configuredProviders = collect([
            'openai' => !empty(config('ai.providers.openai.key')),
            'anthropic' => !empty(config('ai.providers.anthropic.key')),
            'gemini' => !empty(config('ai.providers.gemini.key')),
            'cohere' => !empty(config('ai.providers.cohere.key')),
            'mistral' => !empty(config('ai.providers.mistral.key')),
        ])->filter()->keys()->all();

        // Compile the verification report.
        $allChecksPass = $aiConfigLoaded
            && $conversationsTableExists
            && $messagesTableExists
            && count($configuredProviders) > 0;

        return response()->json([
            'status' => $allChecksPass ? 'ready' : 'incomplete',
            'checks' => [
                'ai_config_loaded' => $aiConfigLoaded,
                'conversations_table_exists' => $conversationsTableExists,
                'messages_table_exists' => $messagesTableExists,
                'configured_providers' => $configuredProviders,
            ],
            'message' => $allChecksPass
                ? 'AI SDK is fully set up and ready to go!'
                : 'Some checks failed. Review the details above.',
        ]);

    }

    public function generateToken(Request $request): JsonResponse
    {
        // Validate the incoming credentials.
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to find the user by email.
        $user = User::where('email', $request->email)->first();

        // Verify the password matches.
        if (!$user || !\Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials.',
            ], 401);
        }

        /**
         * Create a new sanctum API token.
         * The token name helps identify what it's for
         * When viewing active tokens later.
         */

        $token = $user->createToken('ai-course-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Token generated successfully. Use this as your Bearer token for all future requests.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);

    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
            ],
            'message' => 'You are authenticated and ready for the AI SDK',
        ]);
    }

}
