<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use denis660\Centrifugo\Centrifugo;
use Illuminate\Console\Command;

// @codeCoverageIgnoreStart
#[AsCommand('centrifugo:run')]
class CentrifugoCommand extends Command
{
    public function handle(Centrifugo $centrifugo): void
    {
        $centrifugo->publish('example', ['time' => now()]);
    }
}
// @codeCoverageIgnoreEnd
