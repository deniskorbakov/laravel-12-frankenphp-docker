<?php

declare(strict_types=1);

namespace App\Builders;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/** @extends Builder<User> */
class UserBuilder extends Builder
{
    public function isEmailVerified(): bool
    {
        return $this->model->email_verified_at !== null;
    }
}
