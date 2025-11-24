<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Dto\Config;

use BackedEnum;
use Sylarele\LaravelSet\Media\Enum\Image\Format;
use Sylarele\LaravelSet\Media\Enum\Image\Position;

final readonly class ImageConfigDto
{
    public function __construct(
        public ?int $resizeHeight = null,
        public ?int $resizeWidth = null,
        public int $quality = 100,
        public ?Position $position = null,
        public Format $format = Format::Webp,
    ) {
    }

    /**
     * @param array<string, int|BackedEnum> $properties
     */
    public static function __set_state(array $properties): self
    {
        $integerData = array_filter($properties, is_int(...));

        return new self(
            resizeHeight: $integerData['resizeHeight'] ?? null,
            resizeWidth: $integerData['resizeWidth'] ?? null,
            quality: $integerData['quality'] ?? 100,
            position: isset($properties['position']) &&  $properties['position'] instanceof Position
                ? $properties['position']
                : null,
            format: isset($properties['format']) &&  $properties['format'] instanceof Format
                ? $properties['format']
                : Format::Webp,
        );
    }
}
