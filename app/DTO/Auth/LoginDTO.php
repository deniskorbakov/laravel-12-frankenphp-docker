<?php

declare(strict_types=1);

namespace App\DTO\Auth;

use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Data;

class LoginDTO extends Data
{
    public function __construct(
        #[Email]
        public string $email,
        #[Password(min:8)]
        public string $password
    ) {
    }
}
