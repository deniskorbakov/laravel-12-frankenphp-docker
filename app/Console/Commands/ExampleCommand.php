<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Events\ExampleEvent;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('example:run')]
class ExampleCommand extends Command
{
    public function handle(): void
    {
        $this->info('Example command run');

        ExampleEvent::dispatch();
    }
}
