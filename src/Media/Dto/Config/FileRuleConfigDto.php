<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Dto\Config;

use RuntimeException;

final readonly class FileRuleConfigDto
{
    private const array MIMES_ALLOWED_DOCUMENT = [
        'csv', 'doc', 'docx', 'pdf', 'png', 'jpg', 'jpeg', 'xls', 'xlsx', 'webp'
    ];

    private const array MIMES_ALLOWED_IMAGE = [
        'png', 'jpg', 'jpeg', 'webp',
    ];

    /**
     * @param array<int,string> $mimes
     */
    private function __construct(
        public string $type,
        public array $mimes,
        public SizeConfigDto $sizeMin,
        public SizeConfigDto $sizeMax,
    ) {
    }

    /**
     * @param array<string, mixed> $properties
     */
    public static function __set_state(array $properties): self
    {
        $stringableData = array_filter($properties, is_string(...));
        /** @var array<array-key,string> $mimes */
        $mimes = \is_array($properties['mimes'])
            ? array_filter($properties['mimes'], is_string(...))
            : [];

        return new self(
            $stringableData['type'],
            array_values($mimes),
            $properties['sizeMin'] instanceof SizeConfigDto
                ? $properties['sizeMin']
                : throw new RuntimeException('sizeMin should be instance of ' . SizeConfigDto::class),
            $properties['sizeMax'] instanceof SizeConfigDto
                ? $properties['sizeMax']
                : throw new RuntimeException('sizeMax should be instance of ' . SizeConfigDto::class),
        );
    }

    public static function fromImage(
        string $sizeMin = '1ko',
        string $sizeMax = '400ko'
    ): FileRuleConfigDto {
        return new self(
            type: 'image',
            mimes: self::MIMES_ALLOWED_IMAGE,
            sizeMin: SizeConfigDto::fromString($sizeMin),
            sizeMax: SizeConfigDto::fromString($sizeMax),
        );
    }

    /**
     * @param array<int,string> $mimes
     */
    public static function fromDocument(
        array  $mimes = self::MIMES_ALLOWED_DOCUMENT,
        string $sizeMin = '1ko',
        string $sizeMax = '15mo'
    ): self {
        return new self(
            type: 'file',
            mimes: $mimes,
            sizeMin: SizeConfigDto::fromString($sizeMin),
            sizeMax: SizeConfigDto::fromString($sizeMax),
        );
    }

    public static function fromPdf(
        string $sizeMin = '1ko',
        string $sizeMax = '15mo'
    ): FileRuleConfigDto {
        return new self(
            type: 'file',
            mimes: ['pdf'],
            sizeMin: SizeConfigDto::fromString($sizeMin),
            sizeMax: SizeConfigDto::fromString($sizeMax),
        );
    }

    /**
     * @param array<int,string> $mimes
     */
    public static function fromFile(
        array  $mimes = [],
        string $sizeMin = '1ko',
        string $sizeMax = '15mo'
    ): FileRuleConfigDto {
        return new self(
            type: 'file',
            mimes: $mimes,
            sizeMin: SizeConfigDto::fromString($sizeMin),
            sizeMax: SizeConfigDto::fromString($sizeMax),
        );
    }
}
