<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Tests\Feature\Http\Controllers;

use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\CoversClass;
use Sylarele\LaravelSet\Media\Http\Resource\FileRuleResource;
use Sylarele\LaravelSet\Media\Rule\FileRule;
use Sylarele\LaravelSet\Media\Service\FileRuleService;
use Sylarele\LaravelSet\Tests\TestCase;

/**
 * @internal
 */
#[CoversClass(FileRuleService::class)]
#[CoversClass(FileRuleResource::class)]
#[CoversClass(FileRule::class)]
final class FileRuleControllerTest extends TestCase
{
    public function testListFileRules(): void
    {
        $response = $this
            ->getJson(
                route('file-rules.index'),
            );

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'name',
                        'file_rule' => [
                            'type',
                            'mimes',
                            'size_min',
                            'size_max',
                        ],
                        'image_config' => [
                            'height',
                            'width',
                        ],
                    ],
                ],
            ]);
    }

    public function testStoreImage(): void
    {
        $file = UploadedFile::fake()
            ->image('image.png')
            ->size(250);

        $response = $this
            ->postJson(
                route('file-rules.index'),
                ['image' => $file]
            );

        $response->assertOk();
    }
}
