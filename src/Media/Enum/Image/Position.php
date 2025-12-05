<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Enum\Image;

enum Position: string
{
    case TopLeft = 'top-left';
    case Top = 'top';
    case TopRight = 'top-right';
    case Left = 'left';
    case Center = 'center';
    case Right = 'right';
    case BottomLeft = 'bottom-left';
    case Bottom = 'bottom';
    case BottomRight = 'bottom-right';
}
