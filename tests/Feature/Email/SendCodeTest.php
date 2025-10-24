<?php

declare(strict_types=1);

use App\Models\User;

test('success - send code', function (): void {
    $user = User::factory()->unverified()->create();

    $this->actingAsApi($user)
        ->getJson(route('emails.send-code'))
        ->assertOk();
});

test('failed - unauthorized user', function (): void {
    $this->getJson(route('emails.send-code'))
        ->assertUnauthorized();
});

test('failed - email is verification', function (): void {
    $user = User::factory()->create();

    $this->actingAsApi($user)
        ->getJson(route('emails.send-code'))
        ->assertClientError();
});
