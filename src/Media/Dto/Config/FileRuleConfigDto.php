<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Dto\Config;

final readonly class FileRuleConfigDto
{
    /**
     * @param array<int,string> $mimes
     */
    private function __construct(
        public string $type,
        public array  $mimes,
        public string $sizeMin,
        public string $sizeMax,
    ) {
    }

    /**
     * @param array<string, string|array<int,string>> $properties
     */
    public static function __set_state(array $properties): self
    {
        $stringableData = array_filter($properties, is_string(...));

        return new self(
            $stringableData['type'],
            \is_array($properties['mimes'])
                ? $properties['mimes']
                : [],
            $stringableData['sizeMin'],
            $stringableData['sizeMax'],
        );
    }

    public static function fromImage(
        string $sizeMin = '1kb',
        string $sizeMax = '400kb'
    ): FileRuleConfigDto {
        return new self(
            type: 'image',
            mimes: ['png', 'jpg', 'jpeg', 'webp'],
            sizeMin: $sizeMin,
            sizeMax: $sizeMax,
        );
    }

    /**
     * @param array<int,string> $mimes
     */
    public static function fromDocument(
        array  $mimes = ['csv', 'doc', 'docx', 'pdf', 'png', 'jpg', 'jpeg', 'xls', 'xlsx'],
        string $sizeMin = '1kb',
        string $sizeMax = '15mb'
    ): self {
        return new self(
            type: 'file',
            mimes: $mimes,
            sizeMin: $sizeMin,
            sizeMax: $sizeMax,
        );
    }

    public static function fromPdf(
        string $sizeMin = '1kb',
        string $sizeMax = '15mb'
    ): FileRuleConfigDto {
        return new self(
            type: 'file',
            mimes: ['pdf'],
            sizeMin: $sizeMin,
            sizeMax: $sizeMax,
        );
    }

    /**
     * @param array<int,string> $mimes
     */
    public static function fromFile(
        array  $mimes = [],
        string $sizeMin = '1kb',
        string $sizeMax = '15mb'
    ): FileRuleConfigDto {
        return new self(
            type: 'file',
            mimes: $mimes,
            sizeMin: $sizeMin,
            sizeMax: $sizeMax,
        );
    }
}
