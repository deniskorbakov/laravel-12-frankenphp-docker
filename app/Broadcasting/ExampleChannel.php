<?php

declare(strict_types=1);

namespace App\Broadcasting;

class ExampleChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(): bool
    {
        return true;
    }
}
