<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Enum\Image;

enum Format: string
{
    case Jpg = 'jpg';
    case Png = 'png';
    case Webp = 'webp';
}
