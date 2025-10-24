<?php

declare(strict_types=1);

namespace App\DTO\Auth;

use App\DTO\User\ShowDTO as UserShowDTO;
use App\Models\User;
use Spatie\LaravelData\Data;

class ShowDTO extends Data
{
    public function __construct(
        public UserShowDTO $user,
        public string $token,
    ) {
    }

    public static function fromModel(User $user): self
    {
        return new self(
            UserShowDTO::from($user),
            $user->createToken('auth_token')->plainTextToken
        );
    }
}
