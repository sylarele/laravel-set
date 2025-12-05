<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Tests\Feature\Http\Controllers;

use Illuminate\Http\UploadedFile;
use Sylarele\LaravelSet\Tests\TestCase;

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
