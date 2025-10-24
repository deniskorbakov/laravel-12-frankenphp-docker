<?php

declare(strict_types=1);

namespace App\Services\User;

use App\DTO\User\ShowDTO;
use App\DTO\User\UpdateDTO;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class UserService
{
    /** @return array<string, mixed> */
    public function show(User $user): array
    {
        return ShowDTO::from($user)->toArray();
    }

    /** @return array<string, mixed> */
    public function roles(): array
    {
        $roles = UserRole::publicRoles();

        return [
            'roles' => array_map(static function ($theme): array {
                return [
                    'id'   => $theme->value,
                    'name' => $theme->displayName(),
                ];
            }, $roles),
        ];
    }

    /** @return array<string, mixed> */
    public function update(User $user, UpdateDTO $updateDTO): array
    {
        if (isset($updateDTO->email) && $user->email !== $updateDTO->email) {
            $user->email_verified_at = null;
            $user->email = $updateDTO->email;
        }

        if (isset($updateDTO->password)) {
            $user->password = Hash::make($updateDTO->password);
        }

        if (isset($updateDTO->name)) {
            $user->name = $updateDTO->name;
        }

        $user->save();

        return ShowDTO::from($user)->toArray();
    }
}
