<?php

declare(strict_types=1);

use App\Enums\Key\CacheKey;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

test('success - verify code', function (): void {
    $user = User::factory()->unverified()->create();

    $this->actingAsApi($user)
        ->getJson(route('emails.send-code'))
        ->assertOk();

    $key = CacheKey::EmailCode->keyById($user->id);
    $code = (int) Cache::get($key);

    $this->actingAsApi($user)
        ->postJson(route('emails.verify-code'), [
            'code' => $code,
        ])
        ->assertOk();
});

test('failed - unauthorized user', function (): void {
    $this->postJson(route('emails.verify-code'))
        ->assertUnauthorized();
});

test('failed - email is verification', function (): void {
    $user = User::factory()->create();

    $this->actingAsApi($user)
        ->postJson(route('emails.verify-code'), [
            'code' => fake()->randomNumber(5),
        ])
        ->assertClientError();
});

test('failed - more retry send wrong code', function (): void {
    $user = User::factory()->unverified()->create();

    $this->actingAsApi($user)
        ->getJson(route('emails.send-code'))
        ->assertOk();

    for ($i = 0; $i < 3; ++$i) {
        $this->actingAsApi($user)
            ->postJson(route('emails.verify-code'), [
                'code' => fake()->randomNumber(5),
            ])
            ->assertClientError();
    }

    $this->actingAsApi($user)
        ->postJson(route('emails.verify-code'), [
            'code' => fake()->randomNumber(5),
        ])
        ->assertStatus(429);
});
