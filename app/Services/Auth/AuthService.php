<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;
use App\DTO\Auth\ShowDTO;
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
    public function register(RegisterDTO $authRegisterDTO): array
    {
        $user = User::query()->create([
            'name'     => $authRegisterDTO->name,
            'role'     => $authRegisterDTO->role,
            'email'    => $authRegisterDTO->email,
            'password' => Hash::make($authRegisterDTO->password),
        ]);

        return ShowDTO::from($user)->toArray();
    }

    /**
     * @return array<string, mixed>
     * @throws ValidationException
     */
    public function login(LoginDTO $authLoginDTO): array
    {
        $user = User::query()->where('email', $authLoginDTO->email)->firstOrFail();

        if (! Hash::check($authLoginDTO->password, $user->password)) {
            throw ValidationException::withMessages(['bad credentials']);
        }

        return ShowDTO::from($user)->toArray();
    }

    /** @return array<string, mixed> */
    public function WSAuth(User $user): array
    {
        $token = $this->centrifugo->generateConnectionToken((string) $user->id);

        return new TokenDTO($token)->toArray();
    }

    public function logout(): void
    {
        auth()->user()?->currentAccessToken()->delete();
    }
}
