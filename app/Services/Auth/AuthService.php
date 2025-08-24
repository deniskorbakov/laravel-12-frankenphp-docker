<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\DTO\Auth\AuthLoginDTO;
use App\DTO\Auth\AuthRegisterDTO;
use App\DTO\User\UserAuthShowDTO;
use App\DTO\WS\TokenDTO;
use App\Models\User;
use denis660\Centrifugo\Centrifugo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final readonly class AuthService
{
    public function __construct(
        private Centrifugo $centrifugo,
    ) {
    }

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

    /** @return array<string, mixed> */
    public function WSAuth(User $user): array
    {
        $token = $this->centrifugo->generateConnectionToken((string) $user->id);

        return new TokenDTO($token)->toArray();
    }

    /** @return array<string, string> */
    public function logout(): array
    {
        auth()->user()?->currentAccessToken()->delete();

        return ['message' => 'Logged out successfully'];
    }
}
