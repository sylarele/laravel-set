<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Contract\Console;

use Illuminate\Console\Scheduling\Schedule;

interface ScheduleInterface
{
    public function handle(Schedule $schedule): void;
}
