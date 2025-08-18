<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\DTO\Auth\AuthLoginDTO;
use App\DTO\Auth\AuthRegisterDTO;
use App\DTO\User\UserAuthShowDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class AuthService
{
    /** @return array<string, mixed> */
    public function register(AuthRegisterDTO $authRegisterDTO): array
    {
        $user = User::query()->create([
            'name'     => $authRegisterDTO->name,
            'role'     => $authRegisterDTO->role,
            'email'    => $authRegisterDTO->email,
            'password' => Hash::make($authRegisterDTO->password),
        ]);

        return UserAuthShowDTO::from($user)->toArray();
    }

    /**
     * @return array<string, mixed>
     * @throws ValidationException
     */
    public function login(AuthLoginDTO $authLoginDTO): array
    {
        $user = User::query()->where('email', $authLoginDTO->email)->firstOrFail();

        if (! Hash::check($authLoginDTO->password, $user->password)) {
            throw ValidationException::withMessages(['bad credentials']);
        }

        return UserAuthShowDTO::from($user)->toArray();
    }

    /** @return array<string, string> */
    public function logout(): array
    {
        auth()->user()?->currentAccessToken()->delete();

        return ['message' => 'Logged out successfully'];
    }
}
