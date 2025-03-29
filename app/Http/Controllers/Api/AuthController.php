<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Validation\ValidationException;
use App\Services\Controllers\AuthService;
use App\DTO\Auth\AuthRegisterDTO;
use App\DTO\Auth\AuthLoginDTO;

final readonly class AuthController
{
    public function __construct(
        private AuthService $authService
    ) {
    }

    /** @return array<string, mixed> */
    public function register(AuthRegisterDTO $authRegisterDTO): array
    {
        return $this->authService->register($authRegisterDTO);
    }

    /**
     * @return array<string, mixed>
     * @throws ValidationException
     */
    public function login(AuthLoginDTO $authLoginDTO): array
    {
        return $this->authService->login($authLoginDTO);
    }

    /** @return array<string, string> */
    public function logout(): array
    {
        return $this->authService->logout();
    }
}
