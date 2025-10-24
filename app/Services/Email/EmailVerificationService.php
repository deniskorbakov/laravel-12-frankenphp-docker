<?php

declare(strict_types=1);

namespace App\Services\Email;

use App\DTO\Email\VerificationCodeDTO;
use App\DTO\User\ShowDTO;
use App\Enums\Key\CacheKey;
use App\Mail\VerifyCodeMail;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Random\RandomException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class EmailVerificationService
{
    /** @return array<string, mixed> */
    public function verify(VerificationCodeDTO $requestDTO): array
    {
        $user = User::query()->findOrFail(auth()->id());

        $key = CacheKey::EmailCode->keyById($user->id);

        if ($user->isEmailVerified()) {
            abort(Response::HTTP_BAD_REQUEST, __('email.verified'));
        }

        $cachedValue = Cache::get($key);
        $code = is_numeric($cachedValue) ? (int)$cachedValue : null;

        if ($code === null || $code !== $requestDTO->code) {
            abort(Response::HTTP_BAD_REQUEST, __('email.err_code'));
        }

        Cache::forget($key);

        $user->email_verified_at = now();
        $user->save();

        return ShowDTO::from($user)->toArray();
    }

    /**
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function send(): array
    {
        $user = User::query()->findOrFail(auth()->id());

        $key = CacheKey::EmailCode->keyById($user->id);

        if ($user->isEmailVerified()) {
            abort(Response::HTTP_BAD_REQUEST, __('email.verified'));
        }

        if (! Cache::get($key)) {
            $code = random_int(1000, 9999);
            $ttl = CacheKey::EmailCode->timeCache();

            Cache::put($key, $code, $ttl);

            try {
                Mail::to($user->email)->send(new VerifyCodeMail($code));
            } catch (Throwable $e) {
                Cache::forget($key);
                Log::error($e->getMessage());

                abort(Response::HTTP_BAD_REQUEST, __('email.err_send'));
            }

            return ['message' => __('email.success_send')];
        }

        abort(Response::HTTP_BAD_REQUEST, __('email.sending'));
    }
}
