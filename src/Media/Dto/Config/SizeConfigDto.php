<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Dto\Config;

use InvalidArgumentException;
use RuntimeException;
use Sylarele\LaravelSet\Media\Enum\File\UnitFormat;

final readonly class SizeConfigDto
{
    public function __construct(
        public float      $size,
        public UnitFormat $unit,
    ) {
    }

    /**
     * @param array<string, mixed> $properties
     */
    public static function __set_state(array $properties): self
    {
        return new self(
            \is_float($properties['size'])
                ? $properties['size']
                : throw new RuntimeException('size should be a float value'),
            $properties['unit'] instanceof UnitFormat
                ? $properties['unit']
                : throw new RuntimeException('sizeMax should be instance of ' . UnitFormat::class),
        );
    }

    public function getBytes(): int
    {
        $bytes = match ($this->unit) {
            UnitFormat::Ko => $this->size * 1_024, // 1024^1
            UnitFormat::Mo => $this->size * 1_048_576, // 1024^2
            UnitFormat::Go => $this->size * 1_073_741_824, // 1024^3
        };

        return (int) $bytes;
    }

    public static function fromString(string $size): self
    {
        $matches = [];

        $isMatch = (bool) preg_match(
            '/^(?P<quantity>\d+(?:[.,]\d+)?)\s*(?P<unit>ko|mo|go)$/i',
            $size,
            $matches
        );

        if ($isMatch === false) {
            throw new InvalidArgumentException(
                \sprintf(
                    'Invalid file size suffix for %s. Must be suffixed by one of these [%s]',
                    $size,
                    UnitFormat::implode()
                )
            );
        }

        $quantity = \floatval(str_replace(',', '.', $matches['quantity']));
        $unit = strtolower($matches['unit']);

        return new self(
            size: $quantity,
            unit: UnitFormat::from($unit)
        );
    }
}
