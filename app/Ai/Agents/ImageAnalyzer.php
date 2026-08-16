<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class ImageAnalyzer implements Agent
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'You are an image analysis expert. When a user attaches '
            . 'an image, carefully examine it and respond to their '
            . 'question about it. Be specific and detailed in your '
            . 'descriptions. If there is text in the image, transcribe'
            . 'it accurately. If there are charts or data, extract '
            . 'and present the information clearly.';
    }

}
