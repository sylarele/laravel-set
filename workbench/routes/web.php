<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Workbench\App\Http\Controllers\FileRuleController;

Route::prefix('file-rules')->name('file-rules.')->group(function () {
    Route::get('/', [FileRuleController::class, 'index'])
        ->name('index');
    Route::post('/', [FileRuleController::class, 'storeImage'])
        ->name('store-image');
});
