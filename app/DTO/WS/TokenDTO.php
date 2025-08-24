<?php

declare(strict_types=1);

namespace App\DTO\WS;

use Spatie\LaravelData\Data;

final class TokenDTO extends Data
{
    public function __construct(
        public string $token,
    ) {
    }
}
