<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTO\User\UserUpdateDTO;
use App\Models\User;
use App\Services\User\UserService;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\UrlParam;

#[Group('Пользователи')]
final readonly class UserController
{
    public function __construct(
        private UserService $userService
    ) {
    }

    /**
     * Получить роли для регистрации
     *
     * @return array<string, mixed>
     */
    public function roles(): array
    {
        return $this->userService->roles();
    }

    /**
     * Просмотреть пользователя
     *
     * @return array<string, mixed>
     */
    #[Authenticated]
    #[UrlParam('userId', 'string', 'ID пользователя', example: 1)]
    public function show(string $userId): array
    {
        $user = User::query()->findOrFail((int) $userId);

        return $this->userService->show($user);
    }

    /**
     * Обновить данные пользователя
     *
     * @return array<string, mixed>
     */
    #[Authenticated]
    #[UrlParam('userId', 'string', 'ID пользователя', example: 1)]
    #[BodyParam('name', 'string', 'Имя пользователя', required: true, example: 'username')]
    #[BodyParam('email', 'string', 'Почта', required: true, example: 'test@example.com')]
    #[BodyParam('avatar', 'file', 'Аватарка', required: false, nullable: true)]
    public function update(string $userId, UserUpdateDTO $requestDTO): array
    {
        $user = User::query()->findOrFail((int) $userId);

        return $this->userService->update($user, $requestDTO);
    }
}
