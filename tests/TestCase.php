<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Tests;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Override;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    /**
     * @param  Application  $app
     */
    #[Override]
    protected function defineEnvironment($app)
    {
        /** @var Repository $config */
        $config = $app['config'];
        // Setup default database to use sqlite :memory:
        tap($config, function (Repository $config): void {
            $config->set('database.default', 'testbench');
            $config->set('database.connections.testbench', [
                'driver'   => 'sqlite',
                'database' => ':memory:',
                'prefix'   => '',
            ]);
        });
    }
}
