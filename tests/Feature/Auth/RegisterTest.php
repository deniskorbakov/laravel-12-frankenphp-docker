<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\User;

test('success - user register', function (): void {
    $this->postJson(route('register'), [
        'name' => fake()->name(),
        'email' => fake()->email(),
        'password' => fake()->password(8),
        'role' => UserRole::User,
    ])->assertOk();
});

test('failed - empty body', function (): void {
    $this->postJson(route('register'))
        ->assertClientError();
});

test('failed - bad name', function (): void {
    $this->postJson(route('register'), [
        'name' => null,
        'email' => fake()->email(),
        'password' => fake()->password(8),
        'role' => UserRole::User,
    ])->assertClientError();
});

test('failed - bad email', function (): void {
    $this->postJson(route('register'), [
        'name' => fake()->name(),
        'email' => 'bad_email',
        'password' => fake()->password(8),
        'role' => UserRole::User,
    ])->assertClientError();
});

test('failed - bad password', function (): void {
    $this->postJson(route('register'), [
        'name' => fake()->name(),
        'email' => fake()->email(),
        'password' => fake()->password(3, 7),
        'role' => UserRole::User,
    ])->assertClientError();
});

test('failed - exist email', function (): void {
    $user = User::factory()->create();

    $this->postJson(route('register'), [
        'name' => fake()->name(),
        'email' => $user->email,
        'password' => fake()->password(8),
        'role' => UserRole::User,
    ])->assertClientError();
});
