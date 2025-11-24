<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\User;

test('success - get public roles', function (): void {
    $user = User::factory()->create();

    $result = $this->actingAsApi($user)
        ->getJson(route('roles'));

    $result->assertOk()
        ->assertJsonStructure(
            [
                'roles' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ]
        );

    $roles = $result->json('roles');

    expect($roles)->toHaveCount(1)
        ->and($roles[0]['id'])->toBe(UserRole::User->value)
        ->and($roles[0]['name'])->toBe(UserRole::User->displayName());
});

test('success - roles structure and content', function (): void {
    $user = User::factory()->create();

    $result = $this->actingAsApi($user)
        ->getJson(route('roles'));

    $roles = $result->json('roles');

    expect($roles)->toHaveCount(1)
        ->and($roles[0])->toEqual(
            [
                'id'   => 'user',
                'name' => 'Пользователь',
            ]
        );
});
