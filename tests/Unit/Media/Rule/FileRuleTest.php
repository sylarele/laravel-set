<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Tests\Unit\Media\Rule;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;
use Sylarele\LaravelSet\Media\Dto\Config\FileRuleConfigDto;
use Sylarele\LaravelSet\Media\Rule\FileRule;
use Sylarele\LaravelSet\Tests\Helper\RuleHelpers;
use Sylarele\LaravelSet\Tests\TestCase;
use Workbench\App\Enums\File\PublicFileType;

class FileRuleTest extends TestCase
{
    use RuleHelpers;

    public function testShouldSucceed(): void
    {
        Config::set('file_rules.rules', [
            PublicFileType::FooImage->value => FileRuleConfigDto::fromImage(),
        ]);

        $file = UploadedFile::fake()
            ->image('image.jpg')
            ->size(250);

        $validated = $this->runValidation(
            value: $file,
            rule: new FileRule(PublicFileType::FooImage),
        );

        $this->assertEquals(
            ['field' => $file],
            $validated
        );
    }

    public function testShouldFail(): void
    {
        Config::set('file_rules.rules', [
            PublicFileType::FooImage->value => FileRuleConfigDto::fromImage(sizeMax: '1mo'),
        ]);

        $file = UploadedFile::fake()->create('example.jpeg', 2048);

        //$this->expectException(ValidationException::class);
        $this->expectExceptionMessage(
            'La taille du fichier de field doit être inférieure à 1 Mo.'
        );

        $validated = $this->runValidation(
            value: $file,
            rule: new FileRule(PublicFileType::FooImage),
        );

        $this->assertEquals(
            ['field' => $file],
            $validated
        );
    }
}
