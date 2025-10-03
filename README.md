# laravel-set

Set of interfaces, objects, and practices to standardise Laravel backends

## Schedule list

Initialise your schedule directory

```txt
app/
└─ Schedule/
    ├─ Command/ # for $schedule->command
    └─ Job/     # for $schedule->job
```

Add your commands and jobs. Then return an anonymous class that inherits from `Sylarele\LaravelSet\Contract\Console\ScheduleInterface`.

```php
<?php

declare(strict_types=1);

use App\Console\Command\AcmeCommand;
use Illuminate\Console\Scheduling\Schedule;
use Sylarele\LaravelSet\Contract\Console\ScheduleInterface;

return new class() implements ScheduleInterface
{
    public function handle(Schedule $schedule): void
    {
        $schedule->command(AcmeCommand::class)->dailyAt('08:00');
        /* [...] */
    }
};
```

Then declare your commands in the kernel

In Laravel 10

```php
<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Sylarele\LaravelSet\Service\ScheduleHandler;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $scheduleHandler = new ScheduleHandler([
            base_path('app/Schedule/Command/*.php'),
            base_path('app/Schedule/Job/*.php'),
        ]);
        $scheduleHandler->handle($schedule);
    }
    
    /* [...] */
}
```

In Laravel >= 11

```php
use Sylarele\LaravelSet\Service\ScheduleHandler;

->withSchedule(
    (new ScheduleHandler([
        dirname(__DIR__).'/app/Schedule/Command/*.php',
        dirname(__DIR__).'/app/Schedule/Job/*.php',
    ]))
    ->handle(...)
)
```

See the schedule list :

```php
php artisan schedule:list
```