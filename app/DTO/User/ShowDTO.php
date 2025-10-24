<?php

declare(strict_types=1);

namespace App\DTO\User;

use Carbon\Carbon;
use Spatie\LaravelData\Data;
use App\Enums\UserRole;
use App\Models\User;

class ShowDTO extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public UserRole $role,
        public ?Carbon $emailVerified,
    ) {
    }

    public static function fromModel(User $user): self
    {
        return new self(
            $user->id,
            $user->name,
            $user->email,
            $user->role,
            $user->email_verified_at
        );
    }
}
