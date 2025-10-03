<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Service;

use Illuminate\Console\Scheduling\Schedule;
use InvalidArgumentException;
use Sylarele\LaravelSet\Contract\Console\ScheduleInterface;

final readonly class ScheduleHandler implements ScheduleInterface
{
    /**
     * @param array<int,string> $commandsDir
     */
    public function __construct(
        private array $commandsDir = [],
    ) {
    }

    public function handle(Schedule $schedule): void
    {
        foreach ($this->commandsDir as $commandDir) {
            $filenames = glob($commandDir);

            if (! \is_array($filenames)) {
                throw new InvalidArgumentException(
                    \sprintf('Error reading from the following pattern: %s', $commandDir)
                );
            }

            $this->setInstance($filenames, $schedule);
        }
    }

    /**
     * @param array<int, string> $filenames
     */
    protected function setInstance(array $filenames, Schedule $schedule): void
    {
        foreach ($filenames as $filename) {
            $scheduleClass = require_once $filename;

            if (! $scheduleClass instanceof ScheduleInterface) {
                throw new InvalidArgumentException(
                    \sprintf(
                        'The file %s must return an instance of %s.',
                        $filename,
                        ScheduleInterface::class,
                    )
                );
            }

            $scheduleClass->handle($schedule);
        }
    }
}
