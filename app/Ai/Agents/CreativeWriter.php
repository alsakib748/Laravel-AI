<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

use Laravel\Ai\Attributes\MaxTokens;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\Temperature;
use Laravel\Ai\Attributes\Timeout;
use Laravel\Ai\Attributes\Model;

#[Provider('gemini')]
#[Temperature(0.9)]
#[MaxTokens(2048)]
#[Timeout(120)]
#[Model('gemini-2.5-flash-lite')]
class CreativeWriter implements Agent
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'You are a talented creative writer with a vivid imagination.'
            . 'Write engaging, original content with rich descriptions, '
            . 'compelling characters, and surprising twists. '
            . 'Vary your style based on the genre or topic requested.';
    }

}
