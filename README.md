# laravel-set

Set of interfaces, objects, and practices to standardise Laravel backends

## Schedule list

Initialise your schedule directory

```txt
app/
└─ Schedule/
    ├─ Command/ # for $schedule->command
    └─ Job/     # for $schedule->job
```

Add your commands and jobs. Then return an anonymous class that inherits from `Sylarele\LaravelSet\Contract\Console\ScheduleInterface`.

```php
<?php

declare(strict_types=1);

use App\Console\Command\AcmeCommand;
use Illuminate\Console\Scheduling\Schedule;
use Sylarele\LaravelSet\Contract\Console\ScheduleInterface;

return new class() implements ScheduleInterface
{
    public function handle(Schedule $schedule): void
    {
        $schedule->command(AcmeCommand::class)->dailyAt('08:00');
        /* [...] */
    }
};
```

Then declare your commands in the kernel

In Laravel 10

```php
<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Sylarele\LaravelSet\Service\ScheduleHandler;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $scheduleHandler = new ScheduleHandler([
            base_path('app/Schedule/Command/*.php'),
            base_path('app/Schedule/Job/*.php'),
        ]);
        $scheduleHandler->handle($schedule);
    }
    
    /* [...] */
}
```

In Laravel >= 11

```php
use Sylarele\LaravelSet\Service\ScheduleHandler;

->withSchedule(
    (new ScheduleHandler([
        dirname(__DIR__).'/app/Schedule/Command/*.php',
        dirname(__DIR__).'/app/Schedule/Job/*.php',
    ]))
    ->handle(...)
)
```

See the schedule list :

```php
php artisan schedule:list
```

## Media

### Rules

When you need to manage multiple media types in your application, it is best to centralize the validation rules in your configuration.

Create an enumeration to list your files:

```php
<?php
enum PublicFileType: string
{
    case FooImage = 'foo:image';
}
```

Create a `file_rules.php` and `image_rules.php` configuration file and declare your validation rules:

```php
<?php
// config/file_rules.php

use Sylarele\LaravelSet\Media\Dto\Config\FileRuleConfigDto;

return [
    'rules' => [
        PublicFileType::FooImage->value => FileRuleConfigDto::fromImage(),
    ],
];
```

The rules available for your media are:

- **FileRuleConfigDto::fromImage()**,
    - `{min: 1ko, max: 400ko, mimes: ['png', 'jpg', 'jpeg', 'webp']}`
- **FileRuleConfigDto::fromFile()**,
    - `{min: 1ko, max: 15mo, mimes: ['*']}`
- **FileRuleConfigDto::fromPdf()**,
    - `{min: 1ko, max: 15mo, mimes: ['pdf']}`
- **FileRuleConfigDto::fromDocument()**,
    - `{min: 1ko, max: 15mo, mimes: ['csv', 'doc', 'docx', 'pdf', 'png', 'jpg', 'jpeg', 'xls', 'xlsx', 'webp']}`

You can also rewrite the rules according to your needs by filling in the input parameters.

```php
<?php
// config/image_rules.php

use Sylarele\LaravelSet\Media\Dto\Config\ImageConfigDto;

return [
    'rules' => [
        PublicFileType::FooImage->value => new ImageConfigDto(
            resizeHeight: 300,
            resizeWidth: 300,
        ),
    ],
];
```

Declare your configurations in your `provider`:

```php
<?php

use Sylarele\LaravelSet\Media\Service\FileRuleService;

public function register(): void
{
    $this->app
        ->when(FileRuleService::class)
        ->needs('$fileRulesConfig')
        ->giveConfig('file_rules.rules');
    $this->app
        ->when(FileRuleService::class)
        ->needs('$imagesConfig')
        ->giveConfig('image_rules.rules');
}
```

In your `FormRequest`, call your rule with the key from your file:

```php
use Sylarele\LaravelSet\Media\Rule\FileRule;

public function rules(): array
{
    return [
        'image' => ['nullable', new FileRule(PublicFileType::FooImage)],
    ];
}
```

You can inform your fronts with an API endpoint using the service and resource provided by the package.

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\File\PublicFileType;
use Illuminate\Http\JsonResponse;
use Sylarele\LaravelSet\Media\Http\Resource\FileRuleResource;
use Sylarele\LaravelSet\Media\Service\FileRuleService;

class FileRuleController
{
    public function __construct(
        private readonly FileRuleService $fileRuleService
    ) {
    }

    public function index(): JsonResponse
    {
        $list = $this->fileRuleService->listByScope(PublicFileType::cases());

        return FileRuleResource::collection($list)->response();
    }
}
```

Modify the translation of the following rules to include the format:

```php
return [
    'gt' => [
        'file' => 'The :attribute field must be greater than :value :format.',
    ],
    'lt' => [
        'file' => 'The :attribute field must be less than :value :format.',
    ],
];
```

The following example will return the following JSON:

```json
{
  "data": [
    {
      "name": "foo:image",
      "file_rule": {
        "type": "image",
        "mimes": [
          "png",
          "jpg",
          "jpeg",
          "webp"
        ],
        "size_min": {
          "size": 1,
          "unit": "ko"
        },
        "size_max": {
          "size": 400,
          "unit": "ko"
        }
      },
      "image_config": {
        "height": 100,
        "width": 100
      }
    }
  ]
}

```