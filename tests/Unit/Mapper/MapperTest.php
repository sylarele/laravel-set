<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Tests\Unit\Mapper;

use PHPUnit\Framework\Attributes\CoversClass;
use RuntimeException;
use Sylarele\LaravelSet\Mapper\Contract\MapperInterface;
use Sylarele\LaravelSet\Mapper\Exception\MapperException;
use Sylarele\LaravelSet\Tests\Feature\Mapper\ExampleDto;
use Sylarele\LaravelSet\Tests\Feature\Mapper\MapperService;
use Sylarele\LaravelSet\Tests\TestCase;

/**
 * @internal
 */
#[CoversClass(MapperService::class)]
#[CoversClass(MapperException::class)]
final class MapperTest extends TestCase
{
    private MapperInterface $mapper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app?->bind(MapperInterface::class, MapperService::class);
        $this->mapper = $this->app?->make(MapperInterface::class) ?? throw new RuntimeException();
    }

    public function testCreateObject(): void
    {
        $dto = $this->mapper->map(
            ExampleDto::class,
            [
                'id' => 1,
                'firstname' => 'test',
                'lastname' => 'test',
            ]
        );

        self::assertInstanceOf(ExampleDto::class, $dto);
        self::assertSame('test', $dto->firstname);
        self::assertSame('test', $dto->lastname);
        self::assertNull($dto->age);
    }

    public function testShouldThrowException(): void
    {
        self::expectException(MapperException::class);
        self::expectExceptionMessage('The given data was invalid.');
        $this->mapper->map(ExampleDto::class, []);
    }
}
