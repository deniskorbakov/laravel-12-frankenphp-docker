<?php

declare(strict_types=1);

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function actingAsApi(User $user): self
    {
        return $this->withToken($user->createToken('auth_token')->plainTextToken);
    }
}
