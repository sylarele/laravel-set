<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Rule;

use BackedEnum;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;
use RuntimeException;
use Sylarele\LaravelSet\Media\Dto\Config\FileRuleConfigDto;
use Sylarele\LaravelSet\Media\Service\FileRuleService;

class FileRule
{
    /**
     * @return array<int,mixed>
     */
    public static function make(BackedEnum $fileType): array
    {
        /** @var FileRuleService $service */
        $service = App::make(FileRuleService::class);
        $rule = $service->find($fileType);

        if (! $rule->fileRuleDto instanceof FileRuleConfigDto) {
            throw new RuntimeException('FileRule rule already defined');
        }

        $file = $rule->fileRuleDto->type === 'file'
            ? Rule::file()
            : Rule::imageFile();

        return [
            $file::types($rule->fileRuleDto->mimes)
                ->between($rule->fileRuleDto->sizeMin, $rule->fileRuleDto->sizeMax),
        ];
    }
}
