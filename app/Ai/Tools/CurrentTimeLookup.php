<?php

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

use Carbon\Carbon;

class CurrentTimeLookup implements Tool
{
    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string
    {
        return 'Get the current date and time for a specified timezone.'
            . 'Use this when a user asks what time it is, what the '
            . 'current data is, or needs time-related information. '
            . 'Returns the time in a human-readable format.';
    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'timezone' => $schema->string()
                ->description('The timezone to get the current time for, '
                    . 'in standard timezone format. (e.g., "America/New_York","Europe/London","Asia/Tokyo","UTC")')
                ->required(),
        ];
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {
        $timezone = $request['timezone'];

        try {
            $now = Carbon::now($timezone);

            return json_encode([
                'timezone' => $timezone,
                'datetime' => $now->toDateTimeString(),
                'date' => $now->toFormattedDateString(),
                'time' => $now->format('g:i A'),
                'day_of_week' => $now->format('l'),
                'utc_offset' => $now->format('P')
            ]);

        } catch (\Exception $e) {
            return "Error: Invalid timezone '{$timezone}'. "
                . "Please use a valid timezone like 'Asia/Tokyo' or 'UTC'";
        }
    }

}
