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

final class FileRuleTest extends TestCase
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

    public function testShouldFailWithoutFile(): void
    {
        Config::set('file_rules.rules', [
            PublicFileType::FooImage->value => FileRuleConfigDto::fromImage(),
        ]);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage(
            'The field field must be a file. (and 3 more errors)'
        );

        $this->runValidation(
            value: 'error',
            rule: new FileRule(PublicFileType::FooImage),
        );
    }

    public function testShouldFailWithBadMime(): void
    {
        Config::set('file_rules.rules', [
            PublicFileType::FooImage->value => FileRuleConfigDto::fromImage(),
        ]);

        $file = UploadedFile::fake()
            ->image('image.gif')
            ->size(250);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage(
            'The field field must be a file of type: png, jpg, jpeg, webp.'
        );

        $this->runValidation(
            value: $file,
            rule: new FileRule(PublicFileType::FooImage),
        );
    }

    public function testShouldFailOnTheMinimumFileSize(): void
    {
        Config::set('file_rules.rules', [
            PublicFileType::FooImage->value => FileRuleConfigDto::fromImage(sizeMin: '2mb'),
        ]);

        $file = UploadedFile::fake()->image('example.webp')->size(1024);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage(
            'La taille du fichier de field doit être supérieure à 2 Mb.'
        );

        $this->runValidation(
            value: $file,
            rule: new FileRule(PublicFileType::FooImage),
        );
    }

    public function testShouldFailOnTheMaximumFileSize(): void
    {
        Config::set('file_rules.rules', [
            PublicFileType::FooImage->value => FileRuleConfigDto::fromImage(sizeMax: '1mb'),
        ]);

        $file = UploadedFile::fake()->image('example.webp')->size(2048);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage(
            'La taille du fichier de field doit être inférieure à 1 Mb.'
        );

        $this->runValidation(
            value: $file,
            rule: new FileRule(PublicFileType::FooImage),
        );
    }
}
