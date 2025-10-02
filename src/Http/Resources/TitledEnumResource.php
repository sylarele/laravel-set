<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Http\Resources;

use BackedEnum;
use HasTitle;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @property BackedEnum&HasTitle $resource
 */
final class TitledEnumResource extends JsonResource
{
    /**
     * @return array<string, string|int>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'value' => $this->resource->value,
            'name' => $this->resource->name,
            'title' => $this->resource->title(),
        ];
    }
}
