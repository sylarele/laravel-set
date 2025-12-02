<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Tests\Helper;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

trait RuleHelpers
{
    /**
     * Running validation.
     *
     * @return array<string,mixed>
     *
     * @throws ValidationException
     */
    protected function runValidation(
        mixed $value,
        ValidationRule $rule,
    ): array {

        $translator = new FileLoader(
            new Filesystem(),
            [
                \dirname(__DIR__, 2).'/workbench/lang',
            ]
        );

        $validator = new Validator(
            new Translator($translator, 'fr'),
            ['field' => $value],
            ['field' => [$rule]]
        );

        return $validator->validate();
    }
}
