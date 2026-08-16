<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

use Laravel\Ai\Providers\Tools\WebSearch;

class WebResearcher implements Agent, HasTools
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'You are a research assistant with access to the web .'
            . 'When a user asks about current events, recent news,'
            . 'or any topic that requires up-to-date information,'
            . 'use web search to find accurate, recent information. '
            . 'Always cite your sources when presenting information '
            . 'found through web search. Be concise and factual.';
    }


    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [
            (new WebSearch)
                ->max(5)
                ->allow([
                    'laravel.com',
                    'laravel-news.com',
                    'github.com/laravel',
                ]),
        ];
    }
}