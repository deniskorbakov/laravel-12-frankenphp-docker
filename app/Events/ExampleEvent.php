<?php

declare(strict_types=1);

namespace App\Events;

use App\Enums\ChannelName;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\Channel;

class ExampleEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use Queueable;

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
            new Channel(
                ChannelName::Example->value
            ),
        ];
    }

    /** @return  array<string, mixed> */
    public function broadcastWith(): array
    {
        return [
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
        ];
    }
}
