<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Dto;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Use to count the states of a query, generally for Tabs in interfcae.
 *
 * @implements Arrayable<string, string|int>
 */
final class StateCountDto implements Arrayable
{
    public function __construct(
        public string $label,
        public string $value,
        public ?int $count,
    ) {
    }

    /**
     * @return array<string, string|int>
     */
    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'value' => $this->value,
            'count' => $this->count ?? 0,
        ];
    }
}
