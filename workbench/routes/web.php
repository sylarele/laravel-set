<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Workbench\App\Http\Controllers\FileRuleController;

Route::get('file-rules', [FileRuleController::class, 'index'])
    ->name('file-rules.index');
