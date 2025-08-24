<?php

declare(strict_types=1);

namespace App\Services\Email;

use App\DTO\Email\EmailVerificationCodeDTO;
use App\DTO\User\UserShowDTO;
use App\Mail\VerifyCodeMail;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Random\RandomException;
use Symfony\Component\HttpFoundation\Response;

class EmailVerificationService
{
    /** @return array<string, mixed> */
    public function verify(EmailVerificationCodeDTO $requestDTO): array
    {
        $user = User::query()->findOrFail(auth()->id());

        $key = 'email_verification_' . $user->id;

        if ($user->email_verified_at) {
            abort(Response::HTTP_BAD_REQUEST, __('email.verified'));
        }

        if (Cache::get($key) === $requestDTO->code) {
            Cache::forget($key);

            $user->email_verified_at = now();
            $user->save();

            return UserShowDTO::from($user)->toArray();
        }

        abort(Response::HTTP_BAD_REQUEST, __('email.err_verified'));
    }

    /**
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function send(): array
    {
        $user = User::query()->findOrFail(auth()->id());

        $key = 'email_verification_' . $user->id;

        if ($user->email_verified_at) {
            abort(Response::HTTP_BAD_REQUEST, __('email.verified'));
        }

        if (! Cache::get($key)) {
            $code = random_int(1000, 9999);
            $ttl = now()->addMinutes(15);

            Cache::put($key, $code, $ttl);

            try {
                Mail::to($user->email)->send(new VerifyCodeMail($code));
            } catch (\Throwable $e) {
                Cache::forget($key);
                Log::error($e->getMessage());

                abort(Response::HTTP_BAD_REQUEST, __('email.err_send'));
            }

            return ['message' => __('email.success_send')];
        }

        abort(Response::HTTP_BAD_REQUEST, __('email.sending'));
    }
}
