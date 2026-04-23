<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Tests\Feature\Mapper;

use Illuminate\Support\Facades\App;
use Sylarele\LaravelSet\Mapper\Contract\MapperInterface;
use Sylarele\LaravelSet\Mapper\Exception\MapperException;
use Throwable;

/**
 * Naive implementation for testing.
 */
class MapperService implements MapperInterface
{
    /**
     * @template TClass of object
     *
     * @param class-string<TClass> $classname
     * @param array<array-key, mixed> $data
     *
     * @return TClass
     */
    public function map(string $classname, array $data): mixed
    {
        try {
            /** @var TClass $dto */
            $dto = App::make($classname, $data);

            return $dto;
        } catch (Throwable $throwable) {
            throw new MapperException(
                'The given data was invalid.',
                $throwable->getCode(),
                $throwable,
            );
        }
    }
}
