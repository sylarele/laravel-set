<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Tests\Feature\Mapper;

final readonly class ExampleDto
{
    public function __construct(
        public int $id,
        public string $firstname,
        public string $lastname,
        public ?int $age,
    ) {
    }
}
