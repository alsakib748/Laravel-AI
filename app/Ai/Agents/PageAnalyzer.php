<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Providers\Tools\WebFetch;

#[Provider('gemini')]
class PageAnalyzer implements Agent, HasTools
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'You are a web page analyst. When given a URL, '
            . 'fetch the page content and provide a clear analysis. '
            . 'You can summarize articles, extract key information, '
            . 'identify main topics, and answer questions about '
            . 'the content of any web page. Always mention the '
            . 'source URL when presenting your findings.';
    }


    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [
            new WebFetch,
        ];
    }
}
