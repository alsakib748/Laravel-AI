<?php

namespace App\Http\Controllers\Api\V1;

use App\Ai\Agents\CourseAssistant;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConversationalAgentController extends Controller
{

    public function startConversation(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $user = $request->user();

        $message = $request->input('message');

        $response = (new CourseAssistant())
            ->forUser($user)
            ->prompt($message);

        return response()->json([
            'chat' => 'Start New Conversations (RemembersConversations)',
            'conversation_id' => $response->conversationId,
            'message' => $message,
            'response' => (string) $response,
            'hint' => 'Save the conversation_id!'
        ]);

    }

    public function continueConversation(Request $request): JsonResponse
    {
        $request->validate([
            'conversation_id' => 'required|string',
            'message' => 'required|string|max:1000'
        ]);

        $user = $request->user();

        $message = $request->input('message');

        $conversation_id = $request->input('conversation_id');

        $response = (new CourseAssistant())
            ->continue($conversation_id, as: $user)
            ->prompt($message);

        return response()->json([
            'chat' => 'Continue conversation (RemembersConversations)',
            'conversation_id' => $response->conversationId,
            'user_message' => $message,
            'assistant_response' => (string) $response,
        ]);

    }

}
