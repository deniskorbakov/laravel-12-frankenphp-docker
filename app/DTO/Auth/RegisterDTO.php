<?php

declare(strict_types=1);

namespace App\DTO\Auth;

use App\Enums\UserRole;
use App\Validations\Attributes\UserPublicRole;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;

class RegisterDTO extends Data
{
    public function __construct(
        #[Unique('users'), Max(225)]
        public string $name,
        #[Unique('users'), Email]
        public string $email,
        #[UserPublicRole]
        public UserRole $role,
        #[Password(min: 8)]
        public string $password,
    ) {
    }
}
