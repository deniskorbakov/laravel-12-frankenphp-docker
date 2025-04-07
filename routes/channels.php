<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('exampleChannel', static function (): bool {
    return true;
});
