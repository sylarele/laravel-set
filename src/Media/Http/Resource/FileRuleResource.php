<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Http\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;
use Sylarele\LaravelSet\Media\Dto\Config\FileRuleConfigDto;
use Sylarele\LaravelSet\Media\Dto\Config\ImageConfigDto;
use Sylarele\LaravelSet\Media\Dto\MediaInfoDto;

/**
 * @property MediaInfoDto $resource
 */
final class FileRuleResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->resource->key,
            'file_rule' => $this->when(
                $this->resource->fileRuleDto instanceof FileRuleConfigDto,
                fn (): array => [
                    'type' => $this->resource->fileRuleDto?->type,
                    'mimes' => $this->resource->fileRuleDto?->mimes,
                    'size_min' => $this->resource->fileRuleDto?->sizeMin,
                    'size_max' => $this->resource->fileRuleDto?->sizeMax,
                ]
            ),
            'image_config' => $this->when(
                $this->resource->imageConfigDto instanceof ImageConfigDto,
                fn (): array => [
                    'height' => $this->resource->imageConfigDto?->resizeHeight,
                    'width' => $this->resource->imageConfigDto?->resizeWidth,
                ]
            ),
        ];
    }
}
