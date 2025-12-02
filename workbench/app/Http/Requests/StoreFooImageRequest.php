<?php

declare(strict_types=1);

namespace Workbench\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sylarele\LaravelSet\Media\Rule\FileRule;
use Workbench\App\Enums\File\PublicFileType;

class StoreFooImageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['nullable', new FileRule(PublicFileType::FooImage)],
        ];
    }

    public function attributes(): array
    {
        return [
            'image' => 'Cover Image',
        ];
    }
}
