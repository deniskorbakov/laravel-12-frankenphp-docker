<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTO\Email\EmailVerificationCodeDTO;
use App\Services\Email\EmailVerificationService;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Group;
use Random\RandomException;

#[Group('Почта')]
final readonly class EmailVerificationController
{
    public function __construct(
        private EmailVerificationService $emailVerificationService
    ) {
    }

    /**
     * Отправить код на почту
     *
     * @return array<string, mixed>
     * @throws RandomException
     */
    #[Authenticated]
    public function send(): array
    {
        return $this->emailVerificationService->send();
    }

    /**
     * Проверить код
     *
     * Стоит ограничение на проверку кода (3 попытки в минуту)
     *
     * @return array<string, mixed>
     */
    #[Authenticated]
    #[BodyParam('code', 'int', 'Код подтверждения', required: true, example: '1234')]
    public function verify(EmailVerificationCodeDTO $requestDTO): array
    {
        return $this->emailVerificationService->verify($requestDTO);
    }
}
