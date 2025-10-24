<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Closure;

final class VerifyEmail
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::query()->findOrFail(auth()->id());

        if (!$user->isEmailVerified()) {
            abort(Response::HTTP_BAD_REQUEST, __('email.not_verified'));
        }

        return $next($request);
    }
}
