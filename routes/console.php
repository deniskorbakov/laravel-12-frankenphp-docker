<?php

declare(strict_types=1);

use App\Console\Commands\CentrifugoCommand;
use App\Console\Commands\ExampleCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(ExampleCommand::class)->everyFiveSeconds();
Schedule::command(CentrifugoCommand::class)->everySecond();
