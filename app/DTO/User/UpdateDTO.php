<?php

declare(strict_types=1);

namespace App\DTO\User;

use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

class UpdateDTO extends Data
{
    public function __construct(
        #[Max(255)]
        public ?string $name,
        #[Unique(
            table: 'users',
            ignore: new RouteParameterReference('userId')
        ), Email]
        public ?string $email,
        #[Min(8), Max(32)]
        public ?string $password,
    ) {
    }
}
