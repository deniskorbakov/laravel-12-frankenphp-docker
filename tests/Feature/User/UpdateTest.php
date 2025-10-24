<?php

declare(strict_types=1);

use App\Models\User;

test('success - update current user', function (): void {
    $user = User::factory()->create();

    $this->actingAsApi($user)
        ->postJson(
            route('users.update', [
                'userId' => $user->id,
            ]),
            [
                'email' => $user->email,
                'name'  => fake()->unique()->name,
            ]
        )
        ->assertOk();
});

test('failed - update another user', function (): void {
    $user = User::factory()->create();
    $user2 = User::factory()->create();

    $this->actingAsApi($user)
        ->postJson(
            route('users.update', [
                'userId' => $user2->id,
            ]),
            [
                'email' => $user->email,
                'name'  => fake()->unique()->name,
            ]
        )
        ->assertClientError();
});

test('failed - none verify email after update email', function (): void {
    $user = User::factory()->create();

    $this->actingAsApi($user)
        ->postJson(
            route('users.update', [
                'userId' => $user->id,
            ]),
            [
                'email' => fake()->unique()->email,
            ]
        )
        ->assertOk();

    $this->actingAsApi($user)
        ->postJson(
            route('users.update', [
                'userId' => $user->id,
            ]),
            [
                'email' => fake()->unique()->email,
            ]
        )
        ->assertClientError();
});

test('failed - unauthorized', function (): void {
    $user = User::factory()->create();

    $this->postJson(route('users.update', [
        'userId' => $user->id,
    ]))->assertUnauthorized();
});
