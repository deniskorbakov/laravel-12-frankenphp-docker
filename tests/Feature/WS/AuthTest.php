<?php

declare(strict_types=1);

use App\Models\User;

test('success - get ws token', function (): void {
    $user = User::factory()->create();

    $this->actingAsApi($user)
        ->getJson(route('ws-auth'))
        ->assertOk();
});

test('failed - get ws token unauthorized', function (): void {
    $this->getJson(route('ws-auth'))
        ->assertUnauthorized();
});
