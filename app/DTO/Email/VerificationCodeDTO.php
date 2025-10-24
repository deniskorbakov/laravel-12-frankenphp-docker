<?php

declare(strict_types=1);

namespace App\DTO\Email;

use Spatie\LaravelData\Attributes\Validation\DigitsBetween;
use Spatie\LaravelData\Data;

final class VerificationCodeDTO extends Data
{
    public function __construct(
        #[DigitsBetween(4, 4)]
        public int $code
    ) {
    }
}
