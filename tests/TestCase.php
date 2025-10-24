<?php

declare(strict_types=1);

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected ?string $apiToken = null;
    protected ?User $user = null;

    protected function actingAsApi(User $user): self
    {
        if (!$this->user instanceof User || $this->user->id !== $user->id) {
            if ($this->apiToken !== null) {
                $this->withToken($this->apiToken)
                    ->getJson(route('logout'))
                    ->assertNoContent();
            }

            $response = $this->postJson(route('login'), [
                'email' => $user->email,
                'password' => 'password',
            ]);

            $this->apiToken = $response->json('token');
            $this->user = $user;
        }

        return $this->withToken($this->apiToken);
    }
}
