<?php

declare(strict_types=1);

use App\Models\User;

test('success - show current user', function (): void {
    $user = User::factory()->create();

    $this->actingAsApi($user)
        ->getJson(
            route('users.show', [
                'userId' => $user->id,
            ])
        )
        ->assertOk();
});

test('success - show another user', function (): void {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $this->actingAsApi($user1)
        ->getJson(
            route('users.show', [
                'userId' => $user2->id,
            ])
        )
        ->assertOk();
});

test('failed - unauthorized', function (): void {
    $user = User::factory()->create();

    $this->getJson(route('users.show', [
        'userId' => $user->id,
    ]))
        ->assertUnauthorized();
});
