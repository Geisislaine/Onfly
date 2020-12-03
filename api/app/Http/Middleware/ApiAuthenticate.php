<?php


namespace App\Http\Middleware;


use Closure;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Support\Facades\Log;
use App\Helpers\Utils;

class ApiAuthenticate extends  BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if($e instanceof TokenInvalidException) {
                Log::error($e);
                if (!env('APP_DEBUG')) {
                    return Utils::ResponseJson(new \Exception("Login invalido"));
                }
                return Utils::ResponseJson($e);

            } else if ($e instanceof TokenExpiredException) {
                Log::error($e);
                if (!env('APP_DEBUG')) {
                    return Utils::ResponseJson(new \Exception("Login expirado"));
                }
                return Utils::ResponseJson($e);
            } else {
                Log::error($e);
                if (!env('APP_DEBUG')) {
                    return Utils::ResponseJson(new \Exception("Login invalido"));
                }
                return Utils::ResponseJson($e);
            }
        }
        return $next($request);
    }
}
