<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTO\WS\TokenDTO;
use App\Models\User;
use App\Services\WS\WSService;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;

#[Group('Веб сокеты')]
final readonly class WSController
{
    public function __construct(
        private WSService $wsService,
    ) {
    }

    /**
     * Получить токен ws
     *
     * Получаем токен авторизованного юзера для ws
     */
    #[Authenticated]
    public function auth(): TokenDTO
    {
        /** @var User $user */
        $user = auth()->user();

        return $this->wsService->auth($user);
    }
}
