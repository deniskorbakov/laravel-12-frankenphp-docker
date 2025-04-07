<?php

declare(strict_types=1);

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\Channel;

class ExampleEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;

    public function __construct()
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('exampleChannel'),
        ];
    }

    /** @return  array<string, mixed> */
    public function broadcastWith(): array
    {
        return [
            'date' => Carbon::now()->format('Y-m-d'),
        ];
    }
}
