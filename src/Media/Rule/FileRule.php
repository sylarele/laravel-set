<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Rule;

use BackedEnum;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;
use RuntimeException;
use Sylarele\LaravelSet\Media\Dto\Config\FileRuleConfigDto;

class FileRule
{
    /**
     * @return array<int,mixed>
     */
    public static function make(BackedEnum $fileType): array
    {
        $rule = Config::get(\sprintf('file_rules.rules.%s', $fileType->value));

        if (! $rule instanceof FileRuleConfigDto) {
            throw new RuntimeException('FileRule rule already defined');
        }

        $file = $rule->type === 'file'
            ? Rule::file()
            : Rule::imageFile();

        return [
            $file::types($rule->mimes)
                ->between($rule->sizeMin, $rule->sizeMax),
        ];
    }
}
