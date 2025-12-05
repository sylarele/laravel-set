<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Enum\File;

enum FileWeightPolicy
{
    case Below;
    case Within;
    case Exceeded;
}
