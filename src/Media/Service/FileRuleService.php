<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Service;

use BackedEnum;
use Sylarele\LaravelSet\Media\Dto\Config\FileRuleConfigDto;
use Sylarele\LaravelSet\Media\Dto\Config\ImageConfigDto;
use Sylarele\LaravelSet\Media\Dto\MediaInfoDto;

class FileRuleService
{
    /**
     * @param array<string, FileRuleConfigDto> $fileRulesConfig
     * @param array<string, ImageConfigDto> $imagesConfig
     */
    public function __construct(
        private readonly array $fileRulesConfig,
        private readonly array $imagesConfig,
    ) {
    }

    /**
     * @param array<int,BackedEnum> $enums
     * @return array<int, MediaInfoDto>
     */
    public function listByScope(array $enums): array
    {
        return array_map($this->find(...), $enums);
    }

    public function find(BackedEnum $key): MediaInfoDto
    {
        return new MediaInfoDto(
            key: $key,
            fileRuleDto: $this->fileRulesConfig[$key->value] ?? null,
            imageConfigDto: $this->imagesConfig[$key->value] ?? null,
        );
    }
}
