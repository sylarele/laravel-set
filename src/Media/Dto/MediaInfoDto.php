<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Dto;

use BackedEnum;
use Sylarele\LaravelSet\Media\Dto\Config\FileRuleConfigDto;
use Sylarele\LaravelSet\Media\Dto\Config\ImageConfigDto;

final readonly class MediaInfoDto
{
    public function __construct(
        public BackedEnum $key,
        public ?FileRuleConfigDto $fileRuleDto,
        public ?ImageConfigDto $imageConfigDto,
    ) {
    }
}
