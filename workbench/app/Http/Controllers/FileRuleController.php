<?php

declare(strict_types=1);

namespace Workbench\App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Sylarele\LaravelSet\Media\Http\Resource\FileRuleResource;
use Sylarele\LaravelSet\Media\Service\FileRuleService;
use Workbench\App\Enums\File\PublicFileType;
use Workbench\App\Http\Requests\StoreFooImageRequest;

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

    public function storeImage(StoreFooImageRequest $request): JsonResponse
    {
        return new JsonResponse(JsonResponse::HTTP_CREATED);
    }
}
