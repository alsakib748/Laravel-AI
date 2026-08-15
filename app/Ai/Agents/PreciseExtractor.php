<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Attributes\MaxTokens;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Temperature;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;


#[Model('openrouter')]
#[Temperature(0.0)]
#[MaxTokens(500)]
class PreciseExtractor implements Agent, HasStructuredOutput
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'You are a precise data extraction assistant.'
            . 'Extract exactly the information requested.'
            . 'Be factual and concise. Do not add opinions or embellishments.'
            . 'If information is not present in the input, use null or empty values.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'name' => $schema->string()
                ->description('Full name of the person')
                ->required(),
            'email' => $schema->string()
                ->description('Email address if found, otherwise empty string')
                ->required(),
            'phone' => $schema->string()
                ->description('Phone number if found, otherwise empty string')
                ->required(),
            'company' => $schema->string()
                ->description('Company or organization name if mentioned')
                ->required(),
        ];
    }

}
