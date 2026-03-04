<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Dto\Config;

final readonly class ImageCompressionLevelDto
{
    /**
     * @param int $sizeFrom Percentage of the total image size relative to the maximum image
     * size at which this level applies
     * @param int $quality Quality percentage applied at this level
     */
    public function __construct(
        public int $sizeFrom,
        public int $quality,
    ) {
    }

    /**
     * @param array<string, int> $properties
     */
    public static function __set_state(array $properties): self
    {
        return new self(
            sizeFrom: $properties['sizeFrom'],
            quality: $properties['quality'],
        );
    }
}
