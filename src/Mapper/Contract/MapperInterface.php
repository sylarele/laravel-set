<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Mapper\Contract;

use Sylarele\LaravelSet\Mapper\Exception\MapperException;

interface MapperInterface
{
    /**
     * @template TClass of object
     *
     * @param class-string<TClass> $classname
     * @param array<array-key, mixed> $data
     *
     * @return TClass
     * @throws MapperException
     */
    public function map(string $classname, array $data): mixed;
}
