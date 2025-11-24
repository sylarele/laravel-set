<?php

declare(strict_types=1);

use Sylarele\LaravelSet\Media\Dto\Config\ImageConfigDto;
use Workbench\App\Enums\File\PublicFileType;

return [
    'rules' => [
        PublicFileType::FooImage->value => new ImageConfigDto(
            resizeHeight: 100,
            resizeWidth: 100,
        ),
    ]
];
