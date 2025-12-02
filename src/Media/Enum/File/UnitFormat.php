<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Enum\File;

enum UnitFormat: string
{
    case Ko = 'ko';
    case Mo = 'mo';
    case Go = 'go';

    public static function implode(): string
    {
        return implode(
            ', ',
            array_column(UnitFormat::cases(), 'value')
        );
    }
}
