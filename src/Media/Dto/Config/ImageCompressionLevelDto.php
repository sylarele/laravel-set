<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Dto\Config;

final readonly class ImageCompressionLevelDto
{
    /**
     * @param int<0, 100> $sizeFrom Percentage of the total image size relative to the maximum image
     * size at which this level applies
     * @param int<1, 100> $quality Quality percentage applied at this level
     */
    public function __construct(
        public int $sizeFrom,
        public int $quality,
    ) {
    }
}
