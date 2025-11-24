<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Tests\Feature\Http\Controllers;

use Sylarele\LaravelSet\Tests\TestCase;

class FileRuleControllerTest extends TestCase
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
}
