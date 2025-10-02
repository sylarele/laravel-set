<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;
use Sylarele\LaravelSet\Dto\StateCountDto;

/** @property StateCountDto $resource */
final class StateCountResource extends JsonResource
{
    /**
     * @return array<string, string|int>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return $this->resource->toArray();
    }
}
