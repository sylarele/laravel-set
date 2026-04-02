<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;

use function Orchestra\Testbench\default_skeleton_path;

return Application::configure(default_skeleton_path())
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
    )
    ->create();
