<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Broadcast;
use App\Broadcasting\ExampleChannel;

Broadcast::channel('exampleChannel', ExampleChannel::class);
