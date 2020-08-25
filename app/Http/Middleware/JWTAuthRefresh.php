<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\ResponseTraits;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException as TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JWTAuthRefresh extends BaseMiddleware
{
    use ResponseTraits;

    public function handle($request, Closure $next)
    {
        if (!$token = $this->auth->setRequest($request)->getToken()) {
            return $this->errorResponse('Token not provided');
        }

        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            try {
                $newToken = $this->auth->setRequest($request)->parseToken()->refresh();
            } catch (TokenExpiredException $e) {
                return $this->errorResponse('Token expired');
            } catch (JWTException $e) {
                return $this->errorResponse('Token invalid');
            }

            header('Authorization: Bearer ' . $newToken);

            JWTAuth::setToken($newToken)->toUser();

            $user = $this->auth->authenticate($newToken);

        } catch (JWTException $e) {
            return $this->errorResponse('Token invalid');
        }

        if (!$user = JWTAuth::parseToken($token)) {
            return $this->errorResponse('User not found');
        }

        return $next($request);
    }
}
