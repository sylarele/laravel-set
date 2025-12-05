<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Enum\File;

enum UnitFormat: string
{
    case Kb = 'kb';
    case Mb = 'mb';
    case Gb = 'gb';

    public static function implode(string $separator = ', '): string
    {
        return implode(
            $separator,
            array_column(UnitFormat::cases(), 'value')
        );
    }
}
