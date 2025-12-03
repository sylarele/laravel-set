<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Service;

use BackedEnum;
use InvalidArgumentException;
use Sylarele\LaravelSet\Media\Dto\Config\FileRuleConfigDto;
use Sylarele\LaravelSet\Media\Dto\Config\ImageConfigDto;
use Sylarele\LaravelSet\Media\Dto\MediaInfoDto;
use Sylarele\LaravelSet\Media\Enum\File\FileWeightPolicy;

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
     * @param array<int, BackedEnum> $enums
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
            fileRuleDto: $this->fileRulesConfig[(string) $key->value],
            imageConfigDto: $this->imagesConfig[(string) $key->value],
        );
    }

    public function findFileRuleOrFail(BackedEnum $key): FileRuleConfigDto
    {
        $rule = $this->find($key);

        return $rule->fileRuleDto instanceof FileRuleConfigDto
            ? $rule->fileRuleDto
            : throw new InvalidArgumentException(
                \sprintf(
                    'File rule does not exist for "%s" key.',
                    $key->value
                )
            );
    }

    /**
     * @param int $size The filesize in bytes
     */
    public function validatedSize(
        BackedEnum $key,
        int $size,
    ): FileWeightPolicy {
        $fileRule = $this->findFileRuleOrFail($key);

        $sizeMin = $fileRule->sizeMin->getBytes();
        if ($size < $sizeMin) {
            return FileWeightPolicy::Below;
        }

        $sizeMax = $fileRule->sizeMax->getBytes();
        if ($size > $sizeMax) {
            return FileWeightPolicy::Exceeded;
        }

        return FileWeightPolicy::Within;
    }

}
