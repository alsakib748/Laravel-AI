<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class DocumentAnalyzer implements Agent
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'You are a document analyst. When a user attaches a file'
            . 'and asks a question about it, read the document carefully '
            . 'and provide a thorough, accurate answer based on its contents. '
            . 'important details. If the user asks something not covered '
            . 'by the document, say so.';
    }

}
