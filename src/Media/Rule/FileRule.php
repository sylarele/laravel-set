<?php

declare(strict_types=1);

namespace Sylarele\LaravelSet\Media\Rule;

use BackedEnum;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Validator;
use Sylarele\LaravelSet\Media\Dto\Config\FileRuleConfigDto;
use Sylarele\LaravelSet\Media\Enum\File\FileWeightPolicy;
use Sylarele\LaravelSet\Media\Service\FileRuleService;

final class FileRule implements ValidationRule, ValidatorAwareRule
{
    protected Validator $validator;

    public function __construct(
        private readonly BackedEnum $fileType,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validator = FacadeValidator::make(
            [$attribute => $value],
            [$attribute => [$this->buildValidationRules()]],
            $this->validator->customMessages,
            $this->validator->customAttributes,
        );

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                $fail($this->validator->getTranslator()->get($message));
            }
        }

        if (!$value instanceof UploadedFile) {
            $fail('validation.file')->translate(['attribute' => $attribute]);

            return;
        }

        $service = $this->getService();
        $ruleFile = $this->getFileRule();

        $isValid = $service
            ->validatedSize(
                $this->fileType,
                (int) $value->getSize(),
            );

        if ($isValid === FileWeightPolicy::Below) {
            $fail('validation.gt.file')->translate([
                'attribute' => $attribute,
                'value' => $ruleFile->sizeMin->size,
                'format' => $ruleFile->sizeMin->unit->name
            ]);
        }

        if ($isValid === FileWeightPolicy::Exceeded) {
            $fail('validation.lt.file')->translate([
                'attribute' => $attribute,
                'value' => $ruleFile->sizeMax->size,
                'format' =>  $ruleFile->sizeMax->unit->name
            ]);
        }
    }

    public function setValidator(Validator $validator): self
    {
        $this->validator = $validator;

        return $this;
    }

    private function buildValidationRules(): File
    {
        $fileRule = $this->getFileRule();

        $file = $fileRule->type === 'file'
            ? Rule::file()
            : Rule::imageFile();

        return $file::types($fileRule->mimes);
    }

    private function getService(): FileRuleService
    {
        /** @var FileRuleService $service */
        $service = App::make(FileRuleService::class);

        return $service;
    }

    private function getFileRule(): FileRuleConfigDto
    {
        return $this->getService()->findFileRuleOrFail($this->fileType);
    }
}
