<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Http\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;
use Sylarele\LaravelSet\Media\Dto\Config\SizeConfigDto;

/**
 * @property SizeConfigDto $resource
 */
class SizeConfigDtoRessource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'size' => $this->resource->size,
            'unit' => $this->resource->unit,
            'bytes' => $this->resource->getBytes(),
        ];
    }
}
