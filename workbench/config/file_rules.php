<?php

declare(strict_types=1);

use Sylarele\LaravelSet\Media\Dto\Config\FileRuleConfigDto;
use Workbench\App\Enums\File\PublicFileType;

return [
    'rules' => [
        PublicFileType::FooImage->value => FileRuleConfigDto::fromImage(),
    ],
];
