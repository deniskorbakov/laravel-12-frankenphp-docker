<?php

declare(strict_types=1);

namespace App\Services\WS;

use App\DTO\WS\TokenDTO;
use App\Models\User;
use denis660\Centrifugo\Centrifugo;

final readonly class WSService
{
    public function __construct(
        private Centrifugo $centrifugo,
    ) {
    }

    public function auth(User $user): TokenDTO
    {
        $token = $this->centrifugo->generateConnectionToken((string) $user->id);

        return new TokenDTO($token);
    }
}
