<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

use Laravel\Ai\Concerns\RemembersConversations;

class CourseAssistant implements Agent, Conversational
{
    use Promptable, RemembersConversations;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'You are a helpful teaching assistant for a laravel AI SDK course'
            . 'You remember everything discussed in the current conversation'
            . 'When the user references something said earlier, acknowledge it and build upon it'
            . 'Keep response concise - 2 to 3 sentences maximum';
    }

}
