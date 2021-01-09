<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

use Closure;

class SellerMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @throws \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!$this->auth->auth->check()) {
            throw new UnauthorizedHttpException('seller-auth', 'Token has expired', 401);
        }

        $this->authenticate($request);

        $token = $this->auth->parseToken();
        $user = $this->auth->toUser($token);

        if ($user->permission != 1) {
            throw new UnauthorizedHttpException('seller-auth', 'Forbidden', 403);
        }

        return $next($request);
    }
}
