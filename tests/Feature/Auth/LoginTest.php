<?php

declare(strict_types=1);

use App\Models\User;

test('success - user login', function (): void {
    $user = User::factory()->create();

    $this->postJson(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertOk();
});

test('failed - empty body', function (): void {
    $this->postJson(route('login'))->assertClientError();
});

test('failed - bad email', function (): void {
    $this->postJson(route('login'), [
        'email' => 'none-email',
        'password' => 'password',
    ])->assertClientError();
});

test('failed - short password', function (): void {
    $user = User::factory()->create();

    $this->postJson(route('login'), [
        'email' => $user->email,
        'password' => '123',
    ])->assertClientError();
});

test('failed - wrong password', function (): void {
    $user = User::factory()->create();

    $this->postJson(route('login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertClientError();
});
