<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Group;

#[Group('Авторизация')]
final readonly class AuthController
{
    public function __construct(
        private AuthService $authService
    ) {
    }

    /**
     * Регистрация пользователя
     *
     * @return array<string, mixed>
     */
    #[BodyParam('name', 'string', 'Имя пользователя', required: true, example: 'name')]
    #[BodyParam('email', 'string', 'Почта', required: true, example: 'test@example.com')]
    #[BodyParam('role', 'string', 'Получить роль для регистрации "/api/users/roles/"', required: true, example: 'user')]
    #[BodyParam('password', 'string', 'Пароль', required: true, example: 'password')]
    public function register(RegisterDTO $authRegisterDTO): array
    {
        return $this->authService->register($authRegisterDTO);
    }

    /**
     * Авторизация пользователя
     *
     * @return array<string, mixed>
     * @throws ValidationException
     */
    #[BodyParam('email', 'string', 'Почта', required: true, example: 'test@example.com')]
    #[BodyParam('password', 'string', 'Пароль', required: true, example: 'password')]
    public function login(LoginDTO $authLoginDTO): array
    {
        return $this->authService->login($authLoginDTO);
    }

    /**
     * WS токен
     *
     * Токен авторизации пользователя с WS
     *
     * @return array<string, mixed>
     */
    #[Authenticated]
    public function WSAuth(): array
    {
        $user = User::query()->findOrFail(auth()->id());

        return $this->authService->WSAuth($user);
    }


    /**
     * Выход из аккаунта
     *
     * @return Response
     */
    #[Authenticated]
    public function logout(): Response
    {
        $this->authService->logout();

        return response()->noContent();
    }
}
