<?php

declare(strict_types=1);

use App\Enums\UserRole;

test('success - enum has correct cases', function (): void {
    $cases = UserRole::cases();

    expect($cases)->toHaveCount(3)
        ->and($cases[0]->name)->toBe('Developer')
        ->and($cases[0]->value)->toBe('developer')
        ->and($cases[1]->name)->toBe('Admin')
        ->and($cases[1]->value)->toBe('admin')
        ->and($cases[2]->name)->toBe('User')
        ->and($cases[2]->value)->toBe('user');
});

test('success - enum displayName returns correct translations', function (): void {
    expect(UserRole::Developer->displayName())->toBe('Разработчик')
        ->and(UserRole::Admin->displayName())->toBe('Администратор')
        ->and(UserRole::User->displayName())->toBe('Пользователь');
});

test('success - enum canFullAccess returns correct bool', function (): void {
    expect(UserRole::Developer->canFullAccess())->toBeTrue()
        ->and(UserRole::Admin->canFullAccess())->toBeTrue()
        ->and(UserRole::User->canFullAccess())->toBeFalse();
});

test('success - enum publicRoles returns correct roles', function (): void {
    $publicRoles = UserRole::publicRoles();

    expect($publicRoles)->toHaveCount(1)
        ->and($publicRoles[0])->toBe(UserRole::User);
});
