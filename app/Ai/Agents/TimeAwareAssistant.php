<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

use App\Ai\Tools\CurrentTimeLookup;

class TimeAwareAssistant implements Agent, HasTools
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'You are a helpful assistant with access to real-time information.'
            . 'When a user asks about the current time, date, or day of the week'
            . 'in any timezone, use the CurrentTimeLookup tool to get accurate date.'
            . 'Present the information in a clear, friendly way.';
    }


    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [
            new CurrentTimeLookup,
        ];
    }
}
