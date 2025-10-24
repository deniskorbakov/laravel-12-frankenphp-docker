<?php

declare(strict_types=1);

namespace App\Enums\Key;

enum CacheKey: string
{
    case EmailCode = 'email_code';

    public function keyById(int|string $id): string
    {
        return $this->value . '_' . $id;
    }

    public function timeCache(): int
    {
        return match ($this) {
            self::EmailCode => 900,
        };
    }
}
