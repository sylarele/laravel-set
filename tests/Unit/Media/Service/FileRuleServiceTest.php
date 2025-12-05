<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Tests\Unit\Media\Service;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\TestDox;
use Sylarele\LaravelSet\Media\Dto\Config\FileRuleConfigDto;
use Sylarele\LaravelSet\Media\Dto\Config\ImageConfigDto;
use Sylarele\LaravelSet\Media\Dto\MediaInfoDto;
use Sylarele\LaravelSet\Media\Enum\File\UnitFormat;
use Sylarele\LaravelSet\Media\Service\FileRuleService;
use Sylarele\LaravelSet\Tests\TestCase;
use Workbench\App\Enums\File\PublicFileType;

/**
 * @internal
 */
#[CoversNothing]
final class FileRuleServiceTest extends TestCase
{
    #[TestDox(
        'Given a set of rules,
        When I call a rule,
        Then the rule is returned.'
    )]
    public function testFindFileRule(): void
    {
        Config::set('file_rules.rules', [
            PublicFileType::FooImage->value => FileRuleConfigDto::fromImage(
                sizeMin: '1mb',
                sizeMax: '2mb'
            ),
        ]);

        /** @var FileRuleService $service */
        $service = App::make(FileRuleService::class);

        $result = $service->find(PublicFileType::FooImage);

        self::assertInstanceOf(FileRuleConfigDto::class, $result->fileRuleDto);
        self::assertSame('image', $result->fileRuleDto->type);
        self::assertSame(['png', 'jpg', 'jpeg', 'webp'], $result->fileRuleDto->mimes);
        self::assertSame(UnitFormat::Mb, $result->fileRuleDto->sizeMin->unit);
        self::assertSame(UnitFormat::Mb, $result->fileRuleDto->sizeMax->unit);
        self::assertSame(1.0, $result->fileRuleDto->sizeMin->size);
        self::assertSame(2.0, $result->fileRuleDto->sizeMax->size);

        self::assertInstanceOf(ImageConfigDto::class, $result->imageConfigDto);
        self::assertSame(100, $result->imageConfigDto->resizeHeight);
        self::assertSame(100, $result->imageConfigDto->resizeWidth);
    }

    #[TestDox(
        'Given a set of rules,
        When I call the rules,
        Then the rules are returned.'
    )]
    public function testListFileRule(): void
    {
        /** @var FileRuleService $service */
        $service = App::make(FileRuleService::class);

        $result = $service->listByScope(PublicFileType::cases());

        self::assertContainsOnlyInstancesOf(MediaInfoDto::class, $result);
    }
}
