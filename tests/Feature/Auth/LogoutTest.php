<?php

declare(strict_types=1);

use App\Models\User;

test('success - logout user', function (): void {
    $user = User::factory()->create();

    $this->actingAsApi($user)
        ->postJson(route('logout'))
        ->assertNoContent();
});

test('failed - unauthorized user', function (): void {
    $this->postJson(route('logout'))
        ->assertUnauthorized();
});
