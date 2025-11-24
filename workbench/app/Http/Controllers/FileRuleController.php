<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Sylarele\LaravelSet\Media\Http\Resource\FileRuleResource;
use Sylarele\LaravelSet\Media\Service\FileRuleService;
use Workbench\App\Enums\File\FileScope;
use Workbench\App\Enums\File\PublicFileType;

class FileRuleController
{
    public function __construct(
        private readonly FileRuleService $fileSystemService
    ) {
    }

    public function index(): JsonResponse
    {
        $list = $this->fileSystemService->listByScope(PublicFileType::cases());

        return FileRuleResource::collection($list)->response();
    }
}
