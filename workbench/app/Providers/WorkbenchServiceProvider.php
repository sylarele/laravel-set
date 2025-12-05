<?php

declare(strict_types=1);

namespace Workbench\App\Providers;

use Illuminate\Support\ServiceProvider;
use Sylarele\LaravelSet\Media\Service\FileRuleService;

class WorkbenchServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app
            ->when(FileRuleService::class)
            ->needs('$fileRulesConfig')
            ->giveConfig('file_rules.rules');
        $this->app
            ->when(FileRuleService::class)
            ->needs('$imagesConfig')
            ->giveConfig('images.rules');
    }

    public function boot(): void
    {
        //
    }
}
